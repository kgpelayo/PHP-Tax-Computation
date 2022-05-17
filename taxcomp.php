<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<?php

function grossIncome($monthlyIncome){
    $totalIncome = $monthlyIncome*13;
    return $totalIncome;
}

function totalDeductions($monthlyIncome, $govtEmployed, $numberOfDependents){

    if ($govtEmployed == "Y"){
        $insuranceDeduction = $monthlyIncome*0.09;
    }
    else {
        $insuranceDeduction = $monthlyIncome*0.11;
    }

    if ($numberOfDependents <=4){
        $dependentDeduction = $numberOfDependents*50000;
    }
    
    else {
        $dependentDeduction = 200000;
    }

    $pagIbigDeductions = $monthlyIncome*0.01375;
    $philHealthDeductions = $monthlyIncome*0.035;
    $personalExemption = 250000;
    $deductions = $dependentDeduction + $personalExemption + ($insuranceDeduction + $philHealthDeductions + $pagIbigDeductions)*12;
    return $deductions;
}

function netTaxableIncome($allIncome, $allDeductions){
    $TaxableIncome = $allIncome - $allDeductions;
    return $TaxableIncome;
}

function payableTax($taxableIncome){

    $Income = $taxableIncome;

    $tax="";

        if ($Income <= 250000){
            $tax = 0;
        }
        else if (250000 < $Income && $Income <= 400000){
            $tax = ($Income-250000)*0.2;
        }
        else if (400000 < $Income && $Income <= 800000){
            $tax = 30000 + ($Income-400000)*0.25;
        }
        else if (800000 < $Income && $Income <= 2000000){
            $tax = 130000 + ($Income-800000)*0.3;
        }
        else if (2000000 < $Income && $Income <= 8000000){
            $tax = 490000 + ($Income-2000000)*0.32;
        }
        else if (8000000 < $Income){
            $tax = 2410000 + ($Income-8000000)*0.35;
        }
        
        return $tax;
}

function getValue(){

    $monthlyIncome = $_POST['monthlyIncome'];
    $govtEmployed = $_POST['govtEmployed'];
    $numberOfDependents = $_POST['numberOfDependents'];

    $totalIncome = grossIncome($monthlyIncome);

    $deductions = totalDeductions($monthlyIncome, $govtEmployed, $numberOfDependents);

    $taxableIncome = netTaxableIncome($totalIncome, $deductions);

    $tax = payableTax($taxableIncome);
    
    print "<p> <br>Total Income = ".$totalIncome;
    print "<br>Total Deductions = ".$deductions;
    print "<br>Taxable Income = ".$taxableIncome;
    print "<br>Payable Tax = ".$tax."</p>";
    print "<br><a href='Tax Comp.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
}
getValue();


?>