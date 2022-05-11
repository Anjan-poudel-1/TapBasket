

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="account-settings__user-details">
                        <div class="account-settings__user-details__image">

                            <img src="./assets/images/meat.jpg">

                            <div class="account-settings__user-details__image__upload">

                            </div>

                        </div>

                        <div class="account-settings__user-details__others">
                            <form  method="POST" action="">
                            

                            <div class="form-control">
                            <p class="form-control__label">
                                User Name
                            </p>
                            <input 
                            class="form-control__input <?php 
                             if(isset($userNameerr)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your full name"
                             name="userName"
                             value="<?php
                                    if($userName){
                                        echo $userName;
                                    }
                                    ?>"
                             />
                             <!-- Error show  -->
                             <?php
                                if(isset($userNameerr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $userNameerr ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>


                            <div class="form-control">
                            <p class="form-control__label">
                                Email Address
                            </p>
                            <input 
                            class="form-control__input <?php 
                             if(isset($emailerror)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your email Address"
                             name="email"
                             readonly
                             value="<?php
                                    if($email){
                                        echo $email;
                                    }
                                    ?>"
                             />
                             <!-- Error show  -->
                             <?php
                                if(isset($emailerror)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $emailerror ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>


                        <div class="form-control ">
                            <p class="form-control__label">
                                Phone Number
                            </p>
                            <input 
                            class="form-control__input <?php 
                             if(isset($phoneNumbererror)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your full name"
                             name="phoneNumber"
                             value="<?php
                                    if($phone){
                                        echo $phone;
                                    }
                                    ?>"
                             />
                             <!-- Error show  -->
                             <?php
                                if(isset($phoneNumbererror)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $phoneNumbererror ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>


                        


                        <div class="account-settings__user-details__others__flex">
                       
                        <div class="form-control">
                            <p class="form-control__label">
                                DOB
                            </p>
                            <input 
                            type="date"
                            class="form-control__input <?php 
                             if(isset($doberr)){
                                 echo " form-control__input--error";
                             }
                            ?>"
                             placeholder="Enter your DOB"
                             name="dob"
                             value="<?php
                                    if($dob){
                                        echo $dob;
                                        
                                    }
                                    ?>"
                             />
                             <!-- Error show  -->
                             <?php
                                if(isset($doberr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $doberr ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>

                        <div class="form-control ">
                            <p class="form-control__label">
                                Gender
                            </p>
                            <select name="gender" 
                            class="form-control__input <?php 
                             if(isset($gendererr)){
                                 echo " form-control__input--error";
                             }?>"
                            >
                                <option name="gender" class="" value="" <?php
                                     if($gender &&  $gender==""){
                                        echo "selected";
                                    }
                                ?>>
                                    Select your gender
                                </option>
                                <option name="gender" class="" value="male" <?php
                                     if(($gender) &&  $gender=="male"){
                                        echo "selected";
                                    }
                                ?>>
                                    Male
                                </option>

                                <option name="gender" class="" value="female" <?php
                                     if($gender &&  $gender=="female"){
                                        echo "selected";
                                    }
                                ?>>
                                    Female
                                </option>

                                <option name="gender" class="" value="other" <?php
                                     if($gender &&  $gender=="other"){
                                        echo "selected";
                                    }
                                ?>>
                                    Others
                                </option>
                            
                            </select>
                            
                             <!-- Error show  -->
                             <?php
                                if(isset($gendererr)){
                                    ?>
                                    <div class="input-error"> 
                                    <?php echo $gendererr ?>
                                     </div> 
                                    <?php
                                        }
                                ?>

                        </div>
                        </div>
                        
                        <div class="account-settings__user-details__others__flex">
                            <input type="submit" value="Update data" name="userProfileUpdate" class="btn primary-btn form-btn"/>
                         
                        </div>

                        

                            </form>
                        </div>
                    </div>
</body>
</html>