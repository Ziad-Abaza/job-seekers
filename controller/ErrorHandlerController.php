<?php
class ErrorHandler
{
    public static function displayErrors($errors)
    {
        if (!empty($errors)) {
            echo '<div class="alert alert-danger p-1 m-2 alert-dismissible fade show" role="alert" data-wow-duration="1s" data-wow-delay="0.5s" data-wow-offset="100">';
            echo '<button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>';
            if(is_array($errors)){
                foreach ($errors as $field => $error) {
                    echo "<strong>$field:</strong> $error<br>";
                }
            }else{
                echo "</strong> $errors<br>";
            }
            echo '</div>';
        }
    }
}

?>