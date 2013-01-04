<?php

namespace Cumts\MainBundle\Service;
use Cumts\MainBundle\Entity\Show;
use Cumts\MainBundle\Entity\ShowRole;
use Cumts\MainBundle\Entity\Performance;

class Camdram
{
    private $query_url;
    private $showdata_url;
    private $em;

    public function __construct($em, $query_url, $showdata_url) {
        $this->em = $em;
        $this->query_url = $query_url;
        $this->showdata_url = $showdata_url;
    }

    public function getShows() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->query_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = simplexml_load_string($data);
        $ids = array();
        foreach ($data->show as $show) {
                $ids[] = (int)$show['id'];        
        }
        return $ids;
    }
    
    public function getShowData($id) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->showdata_url."?type=json&showid=".$id);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($data);

        //Add overall start and end date for show
        list($earliest, $latest) = $this->getDates($data->performances);
        $data->start_at = $earliest;
        $data->end_at = $latest;

        return $data;
    }
        
    public function addOrUpdateShow($id) {
        $s = $this->em->getRepository('CumtsMainBundle:Show')->findOneBy(array('camdram_id' => $id));
        if ($s) $this->updateShow($s);
        else $this->addShow($id);
    }
        
    public function updateShow($show) {
       echo ($show->getTitle()."\r\n");
        $data = $this->getShowData($show->getCamdramId());
        $show->setTitle($data->title);
        $show->setAuthor($data->author);
        $show->setVenue($data->venue);
        
        foreach ($show->getPerformances() as $p) {
                //Find performances in data
                $data_p = null;
                foreach ($data->performances as &$perf) {
                        if ($p->getStartAt() == new \DateTime($perf->date->value, new \DateTimeZone($perf->date->timezone))) {
                                $data_p = $perf;
                                break;
                        }
                }
                if ($data_p) {
                    $data_p->found = true;
                    $p->setVenue($data_p->venue);
                }
                else {
                    $this->em->remove($p);
                }
        }
        foreach ($data->performances as &$perf) {
            if (!isset($perf->found)) {
                $p = new Performance;
                $p->setShow($show);
                $p->setStartAt($this->convertDate($perf->date));
                $p->setVenue($perf->venue);
                $show->addPerformance($p);
                $this->em->persist($p);
            }
        }
        list($earliest, $latest) = $this->getDates($data->performances);
        $show->setStartAt($earliest);
        $show->setEndAt($latest);
        $this->updateRoles($show, $data->cast, 'cast');
        $this->updateRoles($show, $data->prod, 'prod');
        $this->updateRoles($show, $data->orchestra, 'orchestra');
        
        $this->em->flush();
    }
    
    private function updateRoles($show, $roles, $type) {
        foreach ($show->getRoles() as $r) {
            if ($r->getRoleType() == $type) {
                //Find performances in data
                $data_r = null;
                foreach ($roles as &$role) {
                    preg_match("/\?person=([0-9]+)$/i",$role->url,$matches);
                    if ($r->getCamdramId() == $matches[1]) {
                        $data_r = $role;
                        break;
                    }
                }
                if ($data_r) {
                    $data_r->found = true;
                    $r->setName($data_r->name);
                    $r->setRole($data_r->role);
                }
                else {
                    $this->em->remove($r);
                }
            }
        }
        foreach ($roles as &$role) {
            if (!isset($role->found)) {
                $r = $this->convertRole($role);
                $r->setRoleType($type);
                $r->setShow($show);
                $this->em->persist($r);
                $r->setSort(0);
            }
        } 
    }
    
    public function addShow($id) {
        $data = $this->getShowData($id);
        $show = new Show;
        $show->setTitle($data->title);
        $show->setAuthor($data->author);
        $show->setVenue($data->venue);
        $show->setSummary("");
        $show->setBody("");
        $show->setTicketUrl("");
        $show->setImage(0);
        $show->setCamdramId($id);
        $show->setStartAt($data->start_at);
        $show->setEndAt($data->end_at);
        $this->em->persist($show);
        
        foreach ($data->performances as $perf) {
                $p = new Performance;
                $p->setShow($show);
                $p->setStartAt($this->convertDate($perf->date));
                $p->setVenue($perf->venue);
                $show->addPerformance($p);
                $this->em->persist($p);                
        }

        $i=0;
        foreach ($data->cast as $role) {
                $r = $this->convertRole($role);
                $r->setRoleType('cast');
                $r->setShow($show);
                $this->em->persist($r);
                $r->setSort($i);
                $i++;
        }
        $i=0;
        foreach ($data->prod as $role) {
                $r = $this->convertRole($role);
                $r->setRoleType('prod');
                $r->setShow($show);
                $this->em->persist($r);
                $r->setSort($i);
                $i++;
        }
        $i=0;
        foreach ($data->orchestra as $role) {
                $r = $this->convertRole($role);
                $r->setRoleType('orchestra');
                $r->setShow($show);
                $r->setSort($i);
                $this->em->persist($r);
                $i++;
        }
        
        $this->em->flush();
    }

    public function getDates($performances) {
        $earliest = null;
        $latest = null;
        foreach ($performances as $p) {
            $date = new \DateTime($p->date->value, new \DateTimeZone($p->date->timezone));
            if (!$earliest || $date < $earliest) $earliest = $date;
            if (!$latest || $date > $latest) $latest = $date;
        }
        return array($earliest, $latest);
    }

    private function convertRole($role_json) {
        $r = new ShowRole;
        $r->setName($role_json->name);
        $r->setRole($role_json->role);
        preg_match("/\?person=([0-9]+)$/i",$role_json->url,$matches);
        $r->setCamdramId($matches[1]);
        $r->setMember($this->findMember($r->getCamdramId(), $r->getName()));
        return $r;
    }
    
    private function findMember($id, $name) {
        $repo = $this->em->getRepository('CumtsMainBundle:Member');
        $m = $repo->findOneBy(array('camdram_id' => $id));
        if ($m) return $m;
        else return null;
    }

    private function convertDate($json_date) {
        return new \DateTime($json_date->date, new \DateTimeZone($json_date->timezone));
    }
}
