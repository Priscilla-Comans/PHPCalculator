<?php
    // get the data from the form
    $investment = filter_input(INPUT_POST, 'investment', 
            FILTER_VALIDATE_FLOAT);
    $interest_rate = filter_input(INPUT_POST, 'interest_rate', 
            FILTER_VALIDATE_FLOAT);
    $years = filter_input(INPUT_POST, 'years', 
            FILTER_VALIDATE_INT);
    $monthly = filter_input(INPUT_POST, 'monthly');
    $hidden = filter_input(INPUT_POST, 'hidden');


    
    // validate investment
    if ($investment === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    } else if ( $investment <= 0 ) {
        $error_message = 'Investment must be greater than zero.'; 
    // validate interest rate
    } else if ( $interest_rate === FALSE )  {
        $error_message = 'Interest rate must be a valid number.'; 
    } else if ( $interest_rate <= 0 ) {
        $error_message = 'Interest rate must be greater than zero.'; 
    // validate years
    } else if ( $years === FALSE ) {
        $error_message = 'Years must be a valid whole number.';
    } else if ( $years <= 0 ) {
        $error_message = 'Years must be greater than zero.';
    } else if ( $years > 30 ) {
        $error_message = 'Years must be less than 31.';
    // set error message to empty string if no invalid entries
    } else {
        $error_message = ''; 
    }

    // if an error message exists, go to the index page
    if ($error_message != '') {
        include('index.php');
        exit();
    }

    

    // calculate the future value
    function get_futureValue ($years, $interest_rate, $investment, $decimals = 2) {
        $future_value = 0;
        $future_value = round($investment *pow(1 + ($interest_rate/100), $years), 2);
        $future_value_f = number_format($future_value, $decimals);
            return '$'.$future_value_f;

    }

    $future_value = get_futureValue($years, $interest_rate, $investment, $decimals = 2);


    // function to format decimal value
    function format_Decimals($investment, $decimals = 2) {
        $investment_f = number_format($investment, $decimals);
        return $investment_f;
    }

    $investment = format_Decimals($investment, $decimals = 2);
    // function for %
    function percent ($interest_rate){
        return $interest_rate . '%';
    }

    $percent = percent($interest_rate, $interest_rate);
    // function for currency
    function currency($investment, $future_value) {
        return '$'. $investment;
    }

    $currency = currency($investment, $investment);

    // apply currency and percent formatting
    //$investment_f = '$'.number_format($investment, 2);
    //$yearly_rate_f = $interest_rate.'%';
    //$future_value_f = '$'.number_format($future_value, 2);
    //$monthly_value_f = '$'.number_format($monthly_value, 2);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Future Value Calculator</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <main>
        <h1>Future Value Calculator</h1>

        <label>Investment Amount:</label>
        <span><?php echo $currency; ?></span><br>

        <label>Yearly Interest Rate:</label>
        <span><?php echo $percent; ?></span><br>

        <label>Number of Years:</label>
        <span><?php echo $years; ?></span><br>

        <label>Future Value:</label>
        <span><?php echo $future_value; ?></span><br>

        <label>Compound Monthly:</label>
        <span><?php 
            if (isset($_POST['hidden'])) {
                echo $hidden;
            }
            elseif (isset($_POST['monthly'])) {
                echo $monthly;
            }
        ?><br>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="Button" value="Go Back" onclick="history.back()"><br>
        </div>



    </main>
</body>
</html>