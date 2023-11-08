function updateTotal() {
    let rows = document.getElementsByTagName('tr');
    let allRatesNonZero = true;

    for (let i = 0; i < rows.length; i++) {
        let rateInput = rows[i].querySelector('.rateInput');
        if (rateInput && (rateInput.value.trim() === '' || parseFloat(rateInput.value.trim()) <= 0)) {
            allRatesNonZero = false;
            break;
        }
    }

    if (allRatesNonZero) {
        document.getElementById('savePayrollButton').removeAttribute('disabled');
    } else {
        document.getElementById('savePayrollButton').setAttribute('disabled', 'disabled');
    }

    updateTotalRate(); // Update total rate
}

function updateTotalRate() {
    let rateInputs = document.getElementsByClassName('rateInput');
    let totalRate = 0;

    for (let i = 0; i < rateInputs.length; i++) {
        totalRate += parseInt(rateInputs[i].value) || 0;
    }

    document.getElementById('totalRate').textContent = totalRate;
    document.getElementById('totalRateInput').value = totalRate;

    calculateNetSalary(); // Call the function to update the net salary whenever the rate changes
}

function calculateNetSalary() {
    let totalDeductionElement = document.getElementById('totalDeduction');
    let totalDeduction = 0;

    if (totalDeductionElement.querySelector('input') !== null) {
        totalDeduction = parseInt(totalDeductionElement.querySelector('input').value) || 0;
    }

    let totalRate = parseInt(document.getElementById('totalRate').textContent) || 0;
    let totalNetSalary = totalRate - totalDeduction;

    document.getElementById('totalNetSalaryAmount').textContent = totalNetSalary;
    document.getElementById('totalNetSalaryInput').value = totalNetSalary;
}

// Find all rateInput and rateArrayInput elements
const rateInputs = document.querySelectorAll('.rateInput');
const rateArrayInputs = document.querySelectorAll('.rateArrayInput');

rateInputs.forEach((input, index) => {
    input.addEventListener('input', function() {
        rateArrayInputs[index].value = this.value.replace(/\D/g, '');
    });
});




// Function to toggle the display of cash advances for a specific employee
function toggleCashAdvances(employeeId) {
    const cashAdvancesTable = document.getElementById('cashAdvances_' + employeeId);
    if (cashAdvancesTable.style.display === 'none') {
        cashAdvancesTable.style.display = 'table';
    } else {
        cashAdvancesTable.style.display = 'none';
    }
}

