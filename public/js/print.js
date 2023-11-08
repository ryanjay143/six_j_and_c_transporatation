


function printForm() {
    var printContent = document.getElementById("printableForm").innerHTML;
    var originalContent = document.body.innerHTML;

    document.body.innerHTML = printContent;
    window.print();

    document.body.innerHTML = originalContent;
}



function generatePDF() {
    var doc = new jsPDF();

    var printableForm = document.getElementById("printableForm");

    // Set PDF properties
    doc.setProperties({
        title: 'Form PDF',
    });

    // Convert the printableForm content to HTML
    var htmlContent = printableForm.innerHTML;

    // Generate PDF from HTML content
    doc.fromHTML(htmlContent, 15, 15, {
        width: 170,
        callback: function (doc) {
            // Save the PDF
            doc.save('form.pdf');
        },
    });
}

