<?php
namespace Cumts\MainBundle\Service;

class Paypal
{
    /**
     * @var string
     */
    private $root_dir;

    /**
     * @var string
     */
    private $cache_dir;

    public function __construct($root_dir, $cache_dir)
    {
        $this->root_dir = $root_dir;
        $this->cache_dir = $cache_dir;
    }

    private function getKey($filename)
    {
        return 'file://'.$this->root_dir.DIRECTORY_SEPARATOR.$filename;
    }

    private function getPrivateKey()
    {
        return $this->getKey('private-key.pem');
    }

    private function getPublicCertificate()
    {
        return $this->getKey('public-cert.pem');
    }

    private function getPaypalCertificate()
    {
        return $this->getKey('paypal-cert.pem');
    }

    public function encryptParams(array $params)
    {
        $params['bn']= 'Cumts_ShoppingCart_CustomPaymentButton_GB';

        $data = "";
        foreach ($params as $key => $value) {
            if ($value) {
                $data .= "$key=$value\n";
            }
        }
        $random_key = sha1($data.microtime().'aldhfjsfhs#12;3');
        $infile = $this->cache_dir.DIRECTORY_SEPARATOR.$random_key.'.in';
        $signedfile = $this->cache_dir.DIRECTORY_SEPARATOR.$random_key.'.signed';
        $outfile = $this->cache_dir.DIRECTORY_SEPARATOR.$random_key.'.out';
        file_put_contents($infile, $data);
//echo(file_get_contents($infile));die();
        openssl_pkcs7_sign($infile, $signedfile, $this->getPublicCertificate(), $this->getPrivateKey(),
            array('From' => 'paypal@cumts.co.uk'), PKCS7_BINARY);

        $signed = file_get_contents($signedfile);
        $signed = explode("\n\n", $signed);
        $signed = base64_decode($signed[1]);
        file_put_contents($signedfile, $signed);
        unset($signed);

        openssl_pkcs7_encrypt($signedfile, $outfile, $this->getPaypalCertificate(), array('From' => 'paypal@cumts.co.uk'), PKCS7_BINARY);

        $data = file_get_contents($outfile);
        $data = explode("\n\n", $data);
        $data = '-----BEGIN PKCS7-----' . "\n" . $data[1] . "\n" . '-----END PKCS7-----';


      /*  $openssl_cmd = "($OPENSSL smime -sign -signer $MY_CERT_FILE -inkey $MY_KEY_FILE " .
            "-outform der -nodetach -binary <<_EOF_\n$data\n_EOF_\n) | " .
            "$OPENSSL smime -encrypt -des3 -binary -outform pem $PAYPAL_CERT_FILE";

        exec($openssl_cmd, $output, $error);*/

        @unlink($infile);
        @unlink($signedfile);
        @unlink($outfile);
        return $data;
    }

}