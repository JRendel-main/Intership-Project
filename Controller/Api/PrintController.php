<?php
// Add FPDF library
App::import('Vendor', 'Fpdf', array('file' => 'fpdf/fpdf.php'));

class PrintController extends AppController
{
    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->RequestHandler->ext = 'pdf';
        $this->loadModel('Crud');
    }

    // Index method to satisfy routing requirements
    public function index()
    {
        // Placeholder method.
        $this->set('message', 'PrintController index method');
        $this->render('/Elements/message'); // Ensure this view exists or adjust as needed.
    }

    public function print()
    {
        // Get the data from the request
        $data = $this->request->input('json_decode', true);

        if (!$data) {
            throw new BadRequestException('No data provided');
        }

        // Initialize FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);

        // Set the title
        $pdf->Cell(0, 10, 'Print Records', 0, 1, 'C');
        $pdf->Ln(10);

        // Check if data contains Crud and Beneficiaries
        if (isset($data['Crud']) && isset($data['beneficiaries'])) {
            // Print user information
            $user = $data['Crud'];
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, 'User Information', 0, 1, 'L');
            $pdf->SetFont('Arial', '', 12);
            $pdf->Cell(0, 10, 'Name: ' . $user['name'], 0, 1);
            $pdf->Cell(0, 10, 'Email: ' . $user['email'], 0, 1);
            $pdf->Cell(0, 10, 'Character: ' . $user['character'], 0, 1);
            $pdf->Cell(0, 10, 'Birthday: ' . date('F j, Y', strtotime($user['bday'])), 0, 1);
            $pdf->Cell(0, 10, 'Status: ' . $user['status'], 0, 1);
            $pdf->Ln(10);

            // Print beneficiaries section
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(0, 10, 'Beneficiaries Information', 0, 1, 'L');
            $pdf->Ln(5); // Add some space

            // Create table header for beneficiaries
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetFillColor(200, 220, 255); // Light blue fill color
            $pdf->Cell(10, 10, '#', 1, 0, 'C', true);
            $pdf->Cell(80, 10, 'Beneficiary Name', 1, 0, 'C', true);
            $pdf->Cell(60, 10, 'Relationship', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Birthday', 1, 1, 'C', true); // Move to the next line

            // Loop through beneficiaries and add to the PDF
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetFillColor(255, 255, 255); // White fill color
            foreach ($data['beneficiaries'] as $index => $beneficiary) {
                $pdf->Cell(10, 10, $index + 1, 1, 0, 'C', true);
                $pdf->Cell(80, 10, $beneficiary['Beneficiary']['name'], 1, 0, 'C', true);
                $pdf->Cell(60, 10, $beneficiary['Beneficiary']['relationship'], 1, 0, 'C', true);
                $pdf->Cell(40, 10, date('F j, Y', strtotime($beneficiary['Beneficiary']['bday'])), 1, 1, 'C', true);
            }
        } else {
            // If either Crud or Beneficiaries are missing, print the CRUD records
            $totalRecords = count($data);
            $pdf->SetFont('Arial', 'I', 12);
            $pdf->Cell(0, 10, 'Total Records: ' . $totalRecords, 0, 1, 'C');
            $pdf->Ln(5); // Add some space

            // Create table header for original data
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetFillColor(200, 220, 255); // Light blue fill color
            $pdf->Cell(10, 10, '#', 1, 0, 'C', true);
            $pdf->Cell(80, 10, 'Fullname', 1, 0, 'C', true);
            $pdf->Cell(60, 10, 'Email', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Character', 1, 1, 'C', true); // Move to the next line

            // Loop through the original data and add to the PDF
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetFillColor(255, 255, 255); // White fill color
            foreach ($data as $index => $record) {
                if (!isset($record['Crud']) && !isset($record['beneficiaries'])) {
                    $pdf->Cell(10, 10, $index + 1, 1, 0, 'C', true);
                    $pdf->Cell(80, 10, $record['name'], 1, 0, 'C', true);
                    $pdf->Cell(60, 10, $record['email'], 1, 0, 'C', true);
                    $pdf->Cell(40, 10, $record['character'], 1, 1, 'C', true);
                }
            }
        }

        // Add footer
        $pdf->Ln(10);
        $pdf->SetFont('Arial', 'I', 10);
        $pdf->Cell(0, 10, 'Generated on: ' . date('Y-m-d H:i:s'), 0, 0, 'C');

        // Set the filename based on the current date and time
        $currentDateTime = date('Y-m-d_H-i-s'); // Format: YYYY-MM-DD_HH-MM-SS
        $pdfFileName = "records_$currentDateTime.pdf"; // Use current date and time for the filename

        // Output the PDF inline in the browser with the new filename
        $pdf->Output('I', $pdfFileName); // I to display inline
        exit;
    }

}
