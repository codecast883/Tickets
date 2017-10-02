<?php

namespace app\Admin\DB;


class ServicesGateway extends Gateway
{
    public function insertService($eventId, $options)
    {

        $sql = "INSERT INTO services (event_id,title,price) VALUES (:event_id,:title,:price)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':title', $options['title']);
        $statement->bindValue(':price', $options['price']);

        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }

    }

    public function getAllServices($eventId)
    {


        $sql = 'SELECT * FROM ' . 'services ' . 'WHERE event_id = ?';
        $services = $this->db->query($sql, [$eventId]);

        return $services;
    }

    public function getService($id)
    {

        $sql = 'SELECT * FROM ' . 'services ' . 'WHERE id = ?';
        $services = $this->db->query($sql, [$id]);

        return $services;
    }

    public function getLastService($eventId)
    {
        $events = $this->getAllServices($eventId);
        return array_pop($events);
    }

    public function deleteService($eventId, $serviceId)
    {


        $sql = 'DELETE FROM services WHERE event_id = :event_id AND id = :id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':id', $serviceId);
        $statement->execute();
    }

    public function getPriceCountPeoples($eventId)
    {


        $sql = 'SELECT * FROM ' . 'price_count_peoples ' . 'WHERE event_id = ?';
        $services = $this->db->query($sql, [$eventId]);
        $price = [];
        $i = 0;
        foreach ($services as $value) {
            $i++;
            $price[$i]['id'] = $value->id;
            $price[$i]['count_peoples'] = $value->count_peoples;
            $price[$i]['price'] = $value->price;
            $price[$i] = (object)$price[$i];
        }

        return $price;
    }

    public function insertPriceCountPeoples($eventId, $options)
    {
        $sql = "INSERT INTO price_count_peoples (event_id,count_peoples,price) VALUES (:event_id,:count_peoples,:price)";
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':count_peoples', $options['count_peoples']);
        $statement->bindValue(':price', $options['price']);

        if ($statement->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePriceCountPeoples($eventId, $serviceId)
    {


        $sql = 'DELETE FROM price_count_peoples WHERE event_id = :event_id AND id = :id';
        $statement = $this->db->dbh->prepare($sql);
        $statement->bindValue(':event_id', $eventId);
        $statement->bindValue(':id', $serviceId);
        $statement->execute();
    }

    public function getLastPriceCountPeoples($eventId)
    {
        $lastPrice = $this->getPriceCountPeoples($eventId);
        return array_pop($lastPrice);
    }


}