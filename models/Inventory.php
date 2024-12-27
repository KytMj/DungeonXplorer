     <?php

class Inventory{
    private $db;
    private $hero_id;

    public function __construct($db, $hero_id)
    {  
        $this->db = $db;
        $this->hero_id = $hero_id;
    }

    public function getInventory() {
        $query = "SELECT Items.ite_id, Items.ite_name, Items.ite_description, Inventory.inven_quantity
                  FROM Inventory
                  JOIN Items ON Inventory.ite_id = Items.ite_id
                  WHERE Inventory.hero_id = :hero_id"; 
        $rqt = $this->db->prepare($query);
        $rqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
        $rqt->execute();
        $result = $rqt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }


    public function add($ite_id, $inven_quantity) {
        $query = "INSERT into Inventory (hero_id, ite_id, inven_quantity)
                  VALUES (:hero_id, :ite_id, :quantity)
                  ON DUPLICATE KEY UPDATE inven_quantity = inven_quantity + :quantity";
        $rqt = $this->db->prepare($query);
        $rqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
        $rqt->bindParam(':ite_id', $ite_id, PDO::PARAM_INT);
        $rqt->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $rqt->execute();
    }


    public function remove($ite_id, $inven_quantity) {
        //retrieveitem's current quantity
        $query = "SELECT inven_quantity FROM Inventory WHERE hero_id = :hero_id AND ite_id = :ite_id";
        $rqt = $this->db->prepare($query);
        $rqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
        $rqt->bindParam(':ite_id', $ite_id, PDO::PARAM_INT);
        $rqt->execute();
    
        $currentQuantity = $rqt->fetchColumn();
    
        //decrease quantity if its positive
        if ($currentQuantity !== false && $currentQuantity >= $inven_quantity) {
            $updateQuery = "UPDATE Inventory
                            SET inven_quantity = inven_quantity - :inven_quantity
                            WHERE hero_id = :hero_id AND ite_id = :ite_id";
            $updateRqt = $this->db->prepare($updateQuery);
            $updateRqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
            $updateRqt->bindParam(':ite_id', $ite_id, PDO::PARAM_INT);
            $updateRqt->bindParam(':inven_quantity', $inven_quantity, PDO::PARAM_INT);
            $updateRqt->execute();
    
            // if updated quantity is <=0, delete item from inventory
            if ($currentQuantity - $inven_quantity <= 0) {
                $deleteQuery = "DELETE FROM Inventory WHERE hero_id = :hero_id AND ite_id = :ite_id";
                $deleteRqt = $this->db->prepare($deleteQuery);
                $deleteRqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
                $deleteRqt->bindParam(':ite_id', $ite_id, PDO::PARAM_INT);
                $deleteRqt->execute();
            }
        } else {
            echo "Item inconnu ou quantité insuffisante.";
        }
    }
    
}

?>