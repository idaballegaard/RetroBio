<?php
require_once __DIR__ . "/../models/Company.php";
require_once __DIR__ . "/BaseRepository.php";
class CompanyRepository extends BaseRepository {
    public function saveCompany(string $companyName) : Company
    {
        UserRepository::dieIfNotAdmin();
        
        $db = $this->connectDatabase();
        if (!$db) return new Company();

        try {
            // Check if company exists
            $stmt = $db->prepare("SELECT companyID FROM Company WHERE name = :name");
            $stmt->bindParam(':name', $companyName, PDO::PARAM_STR);
            $stmt->execute();
            $companyID = $stmt->fetchColumn();

            // If not exists, insert new company
            if (!$companyID) {
                $insertStmt = $db->prepare("INSERT INTO Company (name) VALUES (:name)");
                $insertStmt->bindParam(':name', $companyName, PDO::PARAM_STR);
                $insertStmt->execute();
                $companyID = $db->lastInsertId();
            }
            $company = new Company();
            $company->setCompanyID((int)$companyID);
            $company->setName($companyName);

            return $company;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return new Company();
        }
    }
}
