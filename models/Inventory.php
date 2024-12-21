     <?php

class Inventory{
    private $db;
    private $heroId;

    public function __construct($db, $heroId)
    {

        $this->db = $db;
        $this->heroId = $heroId;
    }


    public function getInventory() {
        $query = "SELECT DX_Items.ite_id, DX_Items.ite_name, DX_Items.ite_description, DX_Inventory.inv_quantity
                  FROM DX_Inventory
                  JOIN DX_Items ON DX_Inventory.item_id = DX_Items.ite_id
                  WHERE DX_Inventory.hero_id = :heroId";
        $rqt = $this->db->prepare($query);
        $rqt->bindParam(':heroId', $this->heroId, PDO::PARAM_INT);
        $rqt->execute();
        return $rqt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function add($itemId, $quantity) {
        $query = "INSERT INTO DX_Inventory (hero_id, item_id, inv_quantity)
                  VALUES (:heroId, :itemId, :quantity)
                  ON DUPLICATE KEY UPDATE inv_quantity = inv_quantity + :quantity";
        $req = $this->db->prepare($query);
        $req->bindParam(':heroId', $this->heroId, PDO::PARAM_INT);
        $req->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $req->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $req->execute();
    }


    public function remove($itemId, $quantity) {
        $query = "UPDATE DX_Inventory
                  SET inv_quantity = inv_quantity - :quantity
                  WHERE hero_id = :heroId AND item_id = :itemId";
        $req = $this->db->prepare($query);
        $req->bindParam(':heroId', $this->heroId, PDO::PARAM_INT);
        $req->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $req->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $req->execute();

        //si qte atteint 0 on suppr complètement l'item
        $deleteQuery = "DELETE FROM DX_Inventory WHERE hero_id = :heroId AND item_id = :itemId AND inv_quantity <= 0";
        $deletereq = $this->db->prepare($deleteQuery);
        $deletereq->bindParam(':heroId', $this->heroId, PDO::PARAM_INT);
        $deletereq->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        $deletereq->execute(); 
    }
}

?>