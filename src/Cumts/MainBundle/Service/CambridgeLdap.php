<?php

namespace Cumts\MainBundle\Service;

class CambridgeLdap
{
    private $address;
    private $dn;

    public function __construct($address, $dn) {
        $this->address = $address;
        $this->dn = $dn;
    }

    public function lookup($crsid) {
        $l = \ldap_connect($this->address);
        $r = \ldap_search($l, $this->dn, "(uid=".$crsid.")", array("misaffiliation", "sn", "ou", "displayname", "instid", "mail"));
        $info = \ldap_get_entries($l, $r);
        if ($info['count'] == 0) return null;
        
        $is_student = array_search("student",$info[0]["misaffiliation"]) !== false;
        $last_name = $info[0]["sn"][0];
        $name = $info[0]["displayname"][0];
        $first_name = trim(str_replace($last_name, "", $name));
        $email = $info[0]["mail"][0];
        $college = NULL;
        if (substr_count($first_name, ".") > 0) $first_name = "";
        
        for ($i=0; $i < $info[0]["ou"]["count"]; $i++) {
                $ou = $info[0]["ou"][$i];
                if (preg_match("/^([A-Z'a-z ]+) \-/", $ou, $matches)) {
                        $college = $matches[1];
                        if (substr($college,-7) == "College") $college = substr($college,0,-8);
                        if ($college == "New Hall") $college = "Murray Edwards";
                }
        }
        
        return array(
                'name' => $name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'is_student' => $is_student, 
                'college' => $college,
                'email' => $email,
                'auth_id' => $crsid,
        );
    }

}
