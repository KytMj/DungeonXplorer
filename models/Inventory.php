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
        return $rqt->fetchAll(PDO::FETCH_ASSOC);
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
        $query = "UPDATE Inventory
                  SET inven_quantity = inven_quantity - :inven_quantity
                  WHERE hero_id = :hero_id AND item_id = :ite_id";
        $rqt = $this->db->prepare($query);
        $rqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
        $rqt->bindParam(':ite_id', $ite_id, PDO::PARAM_INT);
        $rqt->bindParam(':inven_quantity', $inven_quantity, PDO::PARAM_INT);
        $rqt->execute();

        //si qte atteint 0 on suppr complètement l'item
        $deleteQuery = "DELETE FROM Inventory WHERE hero_id = :hero_id AND item_id = :ite_id AND inven_quantity <= 0";
        $deleteRqt = $this->db->prepare($deleteQuery);
        $deleteRqt->bindParam(':hero_id', $this->hero_id, PDO::PARAM_INT);
        $deleteRqt->bindParam(':ite_id', $itemId, PDO::PARAM_INT);
        $deleteRqt->execute(); 
    }
}

?>