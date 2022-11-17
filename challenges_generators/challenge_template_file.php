<?php

/**
 * --------------------------
 * CHALLENGE TEMPLATE FILE
 * By Kevin F.
 * --------------------------
 * 
 * When creating a challenge, we must follow this file
 * and the rules associated with it
 * 
 * If the functions are wrong, the challenge is going
 * to mess up. So be careful.
 * 
 * --------------------------
 * FUNCTION DOCUMENTATION
 * --------------------------
 * 
 * ----------------
 * 
 * function challengeGenerator ()
 * @param NOTHING
 * @return NUMBER|STRING : The solution to the problem
 * 
 * The solution has to generate a file named $__FILE_NAME__
 * 
 * This file contains a generated challenge data for the user
 * that way, everyone has a different answer to give
 * 
 * STRING is the answer to this generated challenge data
 * You may compute STRING with the computeSolution()
 * function.
 * 
 * ----------------
 * 
 * function computeSolution (mixed $problemData)
 * @param problemData : The problem data we want to process
 * @return NUMBER|STRING : The solution to the problem
 * 
 * ----------------
 * 
 * function verifySolution (mixed $solutionGiven)
 * @param solutionGiven : The solution given by the user
 * @return BOOLEAN : Is the solution valid ?
 * 
 * Pre-implemented, but be sure to check that it works by
 * checking that :
 * 
 *      verifySolution(challengeGenerator())
 * 
 * is true. (Test on local machine ofc)
 */


//-------------------------------------------------------
// CONSTANTS, DO NOT MODIFY
//-------------------------------------------------------


$__ID_USER__     = $_SESSION["userid"];
$__ID_EXERCICE__ = isset($_POST["challenge"]) ? $_POST["challenge"] : $_SESSION["last_unstarted_challenge"];
$__FILE_NAME__   = "../challenge_inputs/" . $__ID_USER__ . "_" . $__ID_EXERCICE__ . "_input.txt";


//-------------------------------------------------------


//-------------------------------------------------------
// challengeGenerator ()
//-------------------------------------------------------


function challengeGenerator () {

}


//-------------------------------------------------------


//-------------------------------------------------------
// computeSolution (mixed $problemData)
//-------------------------------------------------------


function computeSolution ($problemData) {

}


//-------------------------------------------------------


//-------------------------------------------------------
// verifySolution (mixed $solutionGiven)
//-------------------------------------------------------


function verifySolution ($solutionGiven) {
    global $__FILE_NAME__;
    
    // Get problem data from the file
    $problemData = file_get_contents($__FILE_NAME__);

    // Use your computeSolution() function
    return $solutionGiven == computeSolution($problemData);
}

?>