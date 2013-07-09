<?php

require_once "DataObject.class.php";

class Budget extends DataObject {

	protected $data = array(
		"memberId" => "",
		"budgetAmt" => "",
		"category" => "",
		"startMonth" => "",
		"startYear" => "",
		"endMonth" => "",
		"endYear" => "",
		"period" => "",
		"budgetId" => "",
		);


public static function getBudgets($startRow, $numRows, $order, $id) {
	if($order == "from") {
		$order = "startYear, endMonth";
	}
	if($order == "to") {
		$order = "endYear, endMonth";
	}
	$conn = parent::connect();
	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_BUDGET . " WHERE memberId = :id ORDER BY $order LIMIT :startRow, :numRows";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->bindValue(":startRow", $startRow, PDO::PARAM_INT);
		$st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
		$st->execute();
		$budgets = array();
		foreach($st->fetchAll() as $row) {
			$budgets[] = new Budget($row);
		}
		$st = $conn->query("SELECT found_rows() AS totalRows");
		$row = $st->fetch();
		parent::disconnect($conn);
		return array($budgets, $row["totalRows"]);

	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

#used to compare to total income
public static function getTotalBudget($id) { /*add filter methods here afterwards*/
	$conn = parent::connect();
	$sql = "SELECT SUM(budgetAmt) FROM " . TBL_BUDGET . " WHERE memberId=:id";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":id", $id, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		return $row["SUM(budgetAmt)"];

	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}

}

#for retrieving individual budgets' records
#FILTER OUT TIMEFRAME AS WELL
public static function getBudget($budgetId) {
	$conn = parent::connect();
	$sql = "SELECT * FROM " . TBL_BUDGET . " WHERE budgetId = :budgetId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":budgetId", $budgetId, PDO::PARAM_INT);
		$st->execute();
		$row = $st->fetch();
		parent::disconnect($conn);

		if($row) return new Budget($row);
	} catch(PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

#returns array of categories
public function listCategories($id) {
	$conn = parent::connect();
	$sql = "SELECT DISTINCT category FROM " . TBL_BUDGET . " WHERE memberId = :id";

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

#adds a new budget to the table
public function insert() {
	$conn = parent::connect();
	$sql = "INSERT INTO " . TBL_BUDGET . " (
		memberId, 
		category,
		budgetAmt,
		startMonth,
		startYear,
		endMonth,
		endYear,
		period
		) VALUES (
		:memberId,
		:category,
		:budgetAmt,
		:startMonth,
		:startYear,
		:endMonth,
		:endYear,
		:period
		)";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":category", $this->data["category"], PDO::PARAM_STR);
		$st->bindValue(":budgetAmt", $this->data["budgetAmt"], PDO::PARAM_STR);
		$st->bindValue(":startMonth", $this->data["startMonth"], PDO::PARAM_STR);
		$st->bindValue(":startYear", $this->data["startYear"], PDO::PARAM_INT);
		$st->bindValue(":endMonth", $this->data["endMonth"], PDO::PARAM_STR);
		$st->bindValue(":endYear", $this->data["endYear"], PDO::PARAM_INT);
		$st->bindValue(":period", $this->data["period"], PDO::PARAM_STR);
		$st->execute();
		parent::disconnect($conn);
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function update() {
	$conn = parent::connect(); #not sure about the memberId part
	$sql = "UPDATE " . TBL_BUDGET . " SET
		memberId = :memberId, 
		category = :category,
		budgetAmt = :budgetAmt,
		startMonth = :startMonth,
		startYear = :startYear,
		endMonth = :endMonth,
		endYear = :endYear,
		period = :period
		WHERE budgetId = :budgetId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":memberId", $this->data["memberId"], PDO::PARAM_INT);
		$st->bindValue(":category", $this->data["category"], PDO::PARAM_STR);
		$st->bindValue(":budgetAmt", $this->data["budgetAmt"], PDO::PARAM_STR);
		$st->bindValue(":startMonth", $this->data["startMonth"], PDO::PARAM_STR);
		$st->bindValue(":startYear", $this->data["startYear"], PDO::PARAM_INT);
		$st->bindValue(":endMonth", $this->data["endMonth"], PDO::PARAM_STR);
		$st->bindValue(":endYear", $this->data["endYear"], PDO::PARAM_INT);
		$st->bindValue(":period", $this->data["period"], PDO::PARAM_STR);
		$st->bindValue(":budgetId", $this->data["budgetId"], PDO::PARAM_INT);
		#print_r($st);
		$st->execute();
		
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}

public function delete() {
	$conn = parent::connect();
	$sql = "DELETE FROM " . TBL_BUDGET . " WHERE budgetId = :budgetId";

	try {
		$st = $conn->prepare($sql);
		$st->bindValue(":budgetId", $this->data["budgetId"], PDO::PARAM_INT);
		$st->execute();
		parent::disconnect($conn);
		
	} catch (PDOException $e) {
		parent::disconnect($conn);
		die("Query failed: " . $e->getMessage());
	}
}


}

?>