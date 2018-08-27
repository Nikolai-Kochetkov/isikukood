<!doctype html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
    <p>Is it personal ID?</p>
  <form class="" action="isikukood.php" method="get">
      <input type="text" name="IDcode" value="" placeholder="ID" required="">
      <input type="submit" name="checkID" value="Check">
  </form>
</body>
</html>
<?php
if(isset($_GET['checkID'])){
    checking();
}
function checking(){
    //----------------------------------------------------
    //Check input data
    //----------------------------------------------------
    if(strlen($_GET['IDcode'])==11 && ctype_digit($_GET['IDcode'])){ //Only numbers in an amount of 11
        $iCode = $_GET['IDcode'];
        if(substr($iCode, 0, 1)<7 && substr($iCode, 0, 1)>0){ //If date of birth between 18th and 22nd centuries
            if(substr($iCode, 0, 1)>4 && substr($iCode, 1, 6)>date("ymd")){ //If year of birth is correct but month or day is in future time
                echo "Month or day is wrong";
            }else{
                if(substr($iCode, 3, 2)>0 && substr($iCode, 3, 2)<13){ //If number of month more than 0 and less than 13
                    /*
                    if(substr($iCode,0,1)>4){
                        $firsNumsOfYear = 20;
                    }else{
                        if(substr($iCode,0,1)>2){
                            $firsNumsOfYear = 19;
                        }else{
                            $firsNumsOfYear = 18;
                        }
                    }
                    (substr($iCode,0,1)>4?"20":(substr($iCode,0,1)>2?"19":"18")) - equal to code above, getting first two values of year 
                    
                    cal_days_in_month(CAL_GREGORIAN,month,year) - return number of days, like february 28 or 29
                    */
                    if(substr($iCode,5,2)<=cal_days_in_month(CAL_GREGORIAN,substr($iCode, 3, 2),(substr($iCode,0,1)>4?"20":(substr($iCode,0,1)>2?"19":"18")).substr($iCode, 1, 2)) && substr($iCode,5,2)>0){ //If numer of days from ID is less or equal to number of days from function and more than 0
                        
                        //-------------------------------------------------------------
                        //ID verification start
                        //-------------------------------------------------------------
                        
                        //Arrays for ID verification
                        $astmeOne = array(1,2,3,4,5,6,7,8,9,1);
                        $astmeTwo = array(3,4,5,6,7,8,9,1,2,3);
                        $sumOne = 0;
                        for($i=0;$i<10;$i++){
                            $sumOne += substr($iCode, $i, 1)*$astmeOne[$i]; //Multiplying first 10 values from ID by values from first array and getting their sum
                        }
                        if($sumOne%11==10){ //If integer after division by 11 is equal 10 
                            $sumTwo = 0;
                            for($i=0;$i<10;$i++){
                                $sumTwo += substr($iCode, $i, 1)*$astmeTwo[$i]; //Multiplying first 10 values from ID by values from second array and getting their sum
                            }
                            if($sumTwo%11==10){ //If integer after division by 11 is equal 10 
                                if(0==substr($iCode, -1)){ //If last digit of ID is 0
                                    echo "ID is correct";
                                }else{
                                    echo "It is not ID";
                                }
                            }else{ //If integer after division by 11 is not equal 10
                                if($sumTwo%11==substr($iCode, -1)){ //If last digit of ID and integer after division by 11 are equals
                                    echo "ID is correct";
                                }else{
                                    echo "It is not ID";
                                }
                            }
                        }else{ //If integer after division by 11 is not equal 10
                            if($sumOne%11==substr($iCode, -1)){ //If last digit of ID and integer after division by 11 are equals
                                echo "ID is correct";
                            }else{
                                echo "It is not ID";
                            }
                        }
                        //-------------------------------------------------
                        //ID verification end
                        //-------------------------------------------------
                        
                    }else{ //If day of month is incorrect
                        echo "Wrong day of birth";
                    }
                }else{ //If month is incorrect
                    echo "Wrong month of birth";
                }
            }   
        }else{ //If first digit of code less than 1 and more than 6
            echo "Wrong first digit";
        }
    }else{ //Wrong size/format of ID
        echo "ID must contain 11 digits";
    }
}
?>
