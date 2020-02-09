<?php

/**
 * Class Linker
 *
 * There is only one public function that accepts a link,
 * and in response gives the number of visits to this link.
 *
 * The class can store links, update the number of visits, and add new links.
 */
class Linker
{
    private $config;

    public function __construct()
    {
        $this->config = include 'config.php';
    }

    /**
     * We accept the link.
     * We are looking for it among the already saved links.
     * If we find, increase the attendance counter by 1.
     * If we do not find, save the link, set the visit counter to 0.
     *
     * @param $link string Link whose number of visits you want to return
     * @return int Number of visits
     */
    public function getCount($link){
        $links = $this->getLinks();
        if(isset($links[$link])){
            $links[$link]++;
        } else {
            $links[$link] = 0;
        }
        $this->write($links);
        return $links[$link];
    }

    /**
     * We read the file with links, return it.
     * @return array array of links, and the number of visits
     */
    private function getLinks(){
        return json_decode(file_get_contents($this->config['linksPath']), true);
    }

    /**
     * We write an array of links to a file with them
     * @param $data array Array with links and the number of visits
     */
    private function write($data){
        file_put_contents($this->config['linksPath'], json_encode($data));
    }
}