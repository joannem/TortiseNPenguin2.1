<?php

require_once "DataObject.class.php";

class Expenditure extends DataObject {

	protected $data = array(
		"memberId" => "",
		"itemId" => "",
		"purchaseDate" => "",
		"item" => "",
		"description" => "",
		"category" => "",
		"cost" => "",
		);

public static function getExpenditures($startRow, $numRows, $order, $id) {
	$conn = parent::connect();
	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_EXPENDITURES . " WHERE memberId=:id ORDER BY $order LIMIT :startRow, :numRows";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->bindValue(":startRow", $startRow, PDO::PARAM_INT);
		$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
		$st->execute();
		$expenditures = array();
		foreach($st->fetchAll() as $row) {
			$expenditures[] = new Expenditure($row);
		}
		$st = $conn->query("SELECT found_rows() AS totalRows");
		$row = $st->fetch();
		parent::disconnect($conn);
		return array($expenditures, $row["totalRows"]);

	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public static function getTotalExpenditure($id) {
	$conn = parent::connect();
	$sql = "SELECT SUM(cost) FROM " . TBL_EXPENDITURES . " WHERE memberId=:id";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		return $row["SUM(cost)"];

	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}

}

#to be minused off from the budget to calculate amt remaining
public static function getExpenditures_B(Budget $budget, $id) {
	//echo 'We are checking out: ';
	//print_r($budget);
	$conn = parent::connect();
	$sql = "SELECT SUM(cost) FROM " . TBL_EXPENDITURES . " WHERE category = :category AND memberId = :id";
	if ($budget->getValueEncoded("period") != "forever") {
		$startDate = createDate($budget->getValueEncoded("startMonth"), $budget->getValueEncoded("startYear"));
		$endDate = createDate($budget->getValueEncoded("endMonth"), $budget->getValueEncoded("endYear"));
		$sql = $sql . " AND purchaseDate >= :startDate AND purchaseDate < :endDate";
	}
	//print $sql;
	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":category", $budget->getValueEncoded("category"), PDO::PARAM_STR);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		if ($budget->getValueEncoded("period") != "forever") {
			$st->bindValue(":startDate", $startDate, PDO::PARAM_STR);
			$st->bindValue(":endDate", $endDate, PDO::PARAM_STR);
		}
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);
		return $row[0];
	} catch(PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}

}

#gets TOTAL expenditures from a given month and year to another given month and year
public function getExpenditures_P($from, $to) {

	$conn = parent::connect();
	$sql = "SELECT SUM(cost) FROM " . TBL_EXPENDITURES . " WHERE memberId = :memberId AND purchaseDate >= :from AND purchaseDate < :to";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":from", $from, PDO::PARAM_STR);
		$st->bindValue(":to", $to, PDO::PARAM_STR);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		//print_r($row);
		return ($row["SUM(cost)"]);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}

}

#returns the sum of all expendiures under that category
public function getExpenditures_C($category) {

	$conn = parent::connect();
	$sql = "SELECT SUM(cost) FROM " . TBL_EXPENDITURES . " WHERE memberId = :memberId AND category = :category";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":category", $category, PDO::PARAM_STR);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		//print_r($row);
		return ($row["SUM(cost)"]);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function getExpenditures_PnC($category, $from, $to) {

	$conn = parent::connect();
	$sql = "SELECT SUM(cost) FROM " . TBL_EXPENDITURES . " WHERE memberId = :memberId AND category = :category AND purchaseDate >= :from AND purchaseDate < :to";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":category", $category, PDO::PARAM_STR);
		$st->bindValue(":from", $from, PDO::PARAM_STR);
		$st->bindValue(":to", $to, PDO::PARAM_STR);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		//print_r($row);
		return ($row["SUM(cost)"]);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

#for retrieving individual expenditures' records
public static function getExpenditure($itemId) {
	$conn = parent::connect();
	$sql = "SELECT * FROM " . TBL_EXPENDITURES . " WHERE itemId = :itemId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":itemId", $itemId, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		if($row) return new Expenditure($row);
	} catch(PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

#returns array of categories
public function listCategories($id) {
	$conn = parent::connect();
	$sql = "SELECT DISTINCT category FROM " . TBL_EXPENDITURES . " WHERE memberId = :id";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetchAll(PDO::FETCH_COLUMN, 0);
		parent::disconnect($conn);
		return $row;
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}

}
public function listCategories_P($id, $from, $to) {
	$conn = parent::connect();
	$sql = "SELECT DISTINCT category FROM " . TBL_EXPENDITURES . " WHERE memberId = :id AND purchaseDate >= :from AND purchaseDate < :to";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->bindValue(":from", $from, PDO::PARAM_STR);
		$st->bindValue(":to", $to, PDO::PARAM_STR);
		$st->execute();
		$row = $st->fetchAll(PDO::FETCH_COLUMN, 0);
		parent::disconnect($conn);
		return $row;
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}

}

#adds a new expenditure to the table
public function insert() {
	$conn = parent::connect();
	$sql = "INSERT INTO " . TBL_EXPENDITURES . " (
		memberId, 
		purchaseDate,
		item,
		description,
		category,
		cost
		) VALUES (
		:memberId,
		:purchaseDate,
		:item,
		:description,
		:category,
		:cost
		)";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":purchaseDate", $this->data["purchaseDate"], PDO::PARAM_STR);
		$st->bindValue(":item", $this->data["item"], PDO::PARAM_STR);
		$st->bindValue(":description", $this->data["description"], PDO::PARAM_STR);
		$st->bindValue(":category", $this->data["category"], PDO::PARAM_STR);
		$st->bindValue(":cost", $this->data["cost"], PDO::PARAM_STR);
		$st->execute();
		parent::disconnect($conn);
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function update() {
	$conn = parent::connect(); #not sure about the memberId part
	$sql = "UPDATE " . TBL_EXPENDITURES . " SET
		memberId = :memberId, 
		purchaseDate = :purchaseDate,
		item = :item,
		description = :description,
		category = :category,
		cost = :cost
		WHERE itemId = :itemId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":purchaseDate", $this->data["purchaseDate"], PDO::PARAM_STR);
		$st->bindValue(":item", $this->data["item"], PDO::PARAM_STR);
		$st->bindValue(":description", $this->data["description"], PDO::PARAM_STR);
		$st->bindValue(":category", $this->data["category"], PDO::PARAM_STR);
		$st->bindValue(":cost", $this->data["cost"], PDO::PARAM_STR);
		$st->bindValue(":itemId", $this->data["itemId"], PDO::PARAM_INT);
		$st->execute();
		#echo 'Value of $st:';
		#print_r($st);
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function delete() {
	$conn = parent::connect();
	$sql = "DELETE FROM " . TBL_EXPENDITURES . " WHERE itemId = :itemId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":itemId", $this->data["itemId"], PDO::PARAM_INT);
		$st->execute();
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

}

?>