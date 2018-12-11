<?php
include "helper.php";

$host = "localhost";
include "config.php"; // SIIT TULEVAD $db_user,$db_pass
$db_name = "kairokoik";
// $db_user = "";
// $db_pass = "";

   $link = mysqli_connect($host,$db_user,$db_pass,$db_name) or die("<br/>ei saanud ühendust => ".mysqli_error());

   $form_data = $_POST; // saame formi väärtused

   if(isset($form_data["action"]["add"])){ // siin tuleks nüüd infot uuendada

      unset($form_data["action"]); // viskan kasutatud key välja, et tsükel oleks lihtsam
      foreach ($form_data as $user_id => $user_data) {
         // TODO siin vahel tuleks sisend ära puhastada enne DB-sse panekut, et kaitsta rünnakute eest.
         $update_sql = "INSERT INTO `users` (`firstname`, `lastname`, `age`) VALUES ('".$user_data["firstname"]."','".$user_data["lastname"]."','".$user_data["age"]."')";

         $insert_query = mysqli_query($link, $update_sql); // <== saada info andmebaasi
         if($insert_query){
            echo "<h3 style='color:green;'>Kasutaja lisatud</h3>";
         }
      }
   }

$first_select = "SELECT * FROM users";
$query_results = mysqli_query($link, $first_select);

?>


<form">
   <table>
       <tr>
         <th>
            <h1>Kasutajad</h1>
         </th>
      </tr>
      <tr>
         <td>
            <span>#</span>
         </td>
         <td>
            <span>Eesnimi</span>
         </td>
         <td>
            <span>Perenimi</span>
         </td>
         <td>
            <span>Vanus</span>
         </td>
      </tr>
      <?php
         while ($result = mysqli_fetch_assoc($query_results)) {
            echo '<tr>
                     <td>
                        <input type="checkbox" name="'.$result["id"].'[toaction]">
                     </td>
                     <td>
                        <span>'.$result["firstname"].'</span>
                     </td>
                     <td>
                        <span>'.$result["lastname"].'</span>
                     </td>
                     <td>
                        <span>'.$result["age"].'</span>
                     </td>
                  </tr>';
         }
      ?>
      <tr>
         <td>
            <input type="submit" name="action[rm]" value="Kustuta">
            <input type="submit" name="action[update]" value="Muuda">
            <a href="form.php">Lisa uus kasutaja</a>
         </td>
      </tr>

   </table>
</form>