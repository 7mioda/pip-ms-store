<?php
namespace App\Controller;

use App\Entity\FlashSale;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Publisher as KevinPublisher;
use Symfony\Component\Mercure\Update;

class Publisher
{
    protected  $publisher;

    public function __construct(KevinPublisher $publisher)
    {
        $this->publisher = $publisher;

    }

    public function publish(String $topic, Array $data)
    {
        $update = new Update(
        $topic,
        json_encode($data)
        );
        $pub = $this->publisher;
        $pub($update);
    }

    public function publishFlashSale(FlashSale $flashSale) {
        $this->publish('http://plantify.it/flash-sales',
            [
             'title' => 'Nouveau vente flash'.$flashSale->getName(),
             'name' => $flashSale->getName(),
             'description' => $flashSale->getDescription(),
             'id' => $flashSale->getId()]);
    }
}
