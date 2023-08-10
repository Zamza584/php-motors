<?php
function checkExistingImage($imgName)
{
    $db = phpmotorsConnect();
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
}

function storeImages($imgPath, $invId, $imgName, $imgPrimary)
{
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO images (invId, imgPath, imgName, imgPrimary) VALUES (:invId, :imgPath, :imgName, :imgPrimary)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
    $stmt->execute();

    $imgPath = makeThumbnailName($imgPath);
    $imgName = makeThumbnailName($imgName);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->bindValue(':imgPrimary', $imgPrimary, PDO::PARAM_INT);
    $stmt->execute();

    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}


function deleteImage($imgId)
{
    $db = phpmotorsconnect();
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $imgId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}

function getImages()
{
    $db = phpmotorsConnect();
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invMake, invModel FROM images JOIN inventory ON images.invId = inventory.invId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}

function getThumbnailPath($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory INNER JOIN images ON inventory.invId=images.invId WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE inventory.invId = :invId) AND images.imgName LIKE "%-tn%"';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}
