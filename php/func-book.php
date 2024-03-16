<?php  

# Get All books function
function get_all_books($con){
   $sql  = "SELECT * FROM books ORDER bY price ASC";
   $stmt = $con->prepare($sql);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
   	  $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}



# Get  book by ID function
function get_book($con, $id){
   $sql  = "SELECT * FROM books WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $book = $stmt->fetch();
   }else {
      $book = 0;
   }

   return $book;
}


# Search books function
function search_books($con, $key){
   # creating simple search algorithm :) 
   $key = "%{$key}%";

   $sql  = "SELECT * FROM books 
            WHERE title LIKE ?
            OR description LIKE ?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$key, $key]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

# get books by category
function get_books_by_category($con, $id){
   $sql  = "SELECT * FROM books WHERE category_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}


# get books by author
function get_books_by_author($con, $id){
   $sql  = "SELECT * FROM books WHERE author_id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
        $books = $stmt->fetchAll();
   }else {
      $books = 0;
   }

   return $books;
}

# Get book details by ID function
function get_book_details_by_id($con, $id){
   $sql  = "SELECT id, title, author_id, category_id FROM books WHERE id=?";
   $stmt = $con->prepare($sql);
   $stmt->execute([$id]);

   if ($stmt->rowCount() > 0) {
   	  $book_details = $stmt->fetch();
   } else {
      $book_details = 0;
   }

   return $book_details;
}

# Get book details if purchased (use to display purchased books on my books page)
function get_user_purchased_books($conn, $user_id) {
   try {
       $stmt = $conn->prepare("SELECT books.* 
                               FROM orders
                               JOIN books ON orders.book_id = books.id
                               WHERE orders.user_id = :user_id
                               AND orders.payment_status = 'Paid'");
       $stmt->bindParam(':user_id', $user_id);
       $stmt->execute();
       $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
       return $result;
   } catch (PDOException $e) {
       # Handle database error
       $em = "Database error: " . $e->getMessage();
       header("Location: index.php?error=$em");
       exit();
   }
}

# Get book details if purchased  (use to display buy & open, download buttons)
function has_user_purchased_book($conn, $user_id, $book_id) {
   try {
       $stmt = $conn->prepare("SELECT 1 
                              FROM orders
                              WHERE user_id = :user_id
                              AND book_id = :book_id
                              AND payment_status = 'Paid'");
       $stmt->bindParam(':user_id', $user_id);
       $stmt->bindParam(':book_id', $book_id);
       $stmt->execute();
       $result = $stmt->fetch(PDO::FETCH_COLUMN);
       return $result !== false; // If the record exists, return true
   } catch (PDOException $e) {
       # Handle database error
       $em = "Database error: " . $e->getMessage();
       header("Location: index.php?error=$em");
       exit();
   }
}


function get_book_by_searchKey($con, $name) {  //conn
   $sql = "SELECT * FROM books WHERE title LIKE :name OR description LIKE :name";
   // $sql = "SELECT * FROM books WHERE title LIKE :name";
   // $sql = "SELECT * FROM books WHERE title OR description LIKE :name";
   $stmt = $con->prepare($sql);
   $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR);
   $stmt->execute();

   if ($stmt->rowCount() > 0) {
       $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
   } else {
       $books = 0;
   }

   return $books;
}