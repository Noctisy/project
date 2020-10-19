<?php

class HelperFunctions{

  public function has_provided_input_for_required_fields($fields){
    // check if parameter contains an array
    if(is_array($fields)){

      // variabele met default boolean false value
      $error = false;

      // loop all name attributes of input fields
      foreach ($fields as $fieldname) {
          // check whether field has been set. If not, make sure error is true
          if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])){
            // echo "Field $fieldname has not been set or empty";
            $error = true;
          }
      }

      // als we geen error hebben gehad, dan geef je een true terug
      if(!$error){
        return true;
      }

      // return false wanneer een input field geen value heeft
      return false;
    }else{
      echo "No array has been supplied as arg";
    }

  }


}

?>
