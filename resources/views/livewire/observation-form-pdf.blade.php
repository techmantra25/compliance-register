<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Nomination Compliance & Observation Report</title>

<style>

body{
    font-family: Arial, Helvetica, sans-serif;
    font-size:14px;
    line-height:1.6;
    margin:40px;
}

.page{
    page-break-after:always;
}

.page:last-child{
    page-break-after:auto;
}

.title{
    font-size:22px;
    font-weight:bold;
    margin-bottom:10px;
}

.subtitle{
    margin-bottom:20px;
}

table{
    width:450px;
    border-collapse:collapse;
    margin-top:15px;
}

th,td{
    border:1px solid #444;
    padding:12px;
    vertical-align:top;
}

th{
    background:#e5e5e5;
    text-align:left;
}

.section{
    margin-top:20px;
}

.observation-box{
    border:1px solid #000;
    height:90px;
    padding:2px;
    margin-top:8px;
}

.signature-line{
    border-bottom:1px solid #000;
    width:300px;
    display:inline-block;
}

</style>
</head>

<body>


<!-- PAGE 1 -->

<div class="page">

<div class="title">NOMINATION COMPLIANCE & OBSERVATION REPORT</div>

<p><strong>Issued by:</strong> Fox & Mandal (WBLA 26)</p>
<p class="subtitle"><strong>Project:</strong> West Bengal Assembly Elections 2026</p>

<table>

<tr>
<th>Field</th>
<th>Details</th>
</tr>

<tr>
<td><strong>Candidate Name</strong></td>
<td>{{ $candidate->name }}</td>
</tr>

<tr>
<td>
<strong>
Assembly <br>
Constituency (AC)
</strong>
</td>
<td>
{{ $candidate->assembly->assembly_number }}
({{ $candidate->assembly->assembly_name_en }})
</td>
</tr>

<tr>
<td><strong>Date & Time</strong></td>
<td>
{{ \Carbon\Carbon::now()->format('F d, Y') }}<br><br>
{{ \Carbon\Carbon::now()->format('H:i') }}
</td>
</tr>

</table>


<div class="section">

<p>
1. The nomination papers (Form 2B and Form 26) have been reviewed for structural completeness and are cleared for formal filing.
</p>

<strong>OBSERVATIONS (if any):</strong>

<div class="observation-box">
    {{ $candidate->observation_description }}
</div>

</div>

</div>



<!-- PAGE 2 -->

<div class="page">

<div class="section">

<p><strong>2. Verification Basis & Disclosures</strong></p>

<p>
This report is issued following a Procedural Review of the nomination papers. The following protocols govern the scope of this clearance:
</p>

<p>
<strong>Documentary Authenticity:</strong> For personal identification and statutory certificates (NOCs, educational proofs), checking is limited to the authenticity and legibility of the supporting documents provided by the candidate.
</p>

<p>
<strong>Reliance on Candidate Disclosures:</strong> For the specific categories listed below, the information is accepted as true and correct based strictly on the candidate’s personal submission and the representations of their professional advisors.
</p>

<ul>

<li>
<strong>Financials:</strong> PAN and Income declarations for Self, Spouse, HUF, and Dependents.
</li>

<li>
<strong>Legal/Criminal:</strong> Declarations regarding pending cases, convictions, FIRs, sections of law, and appeal statuses.
</li>

<li>
<strong>Assets:</strong> Details concerning movable and immovable property values.
</li>

</ul>

<p>
Form 26 is a sworn affidavit, and the ultimate legal burden for the accuracy of these disclosures rests solely with the deponent (the candidate). The firm’s role is limited to ensuring the form is technically unassailable for the purposes of the Returning Officer's scrutiny.
</p>

</div>

</div>



<!-- PAGE 3 -->

<div class="page">

<h3>Acknowledgement</h3>

<p><strong>For Fox & Mandal:</strong></p>

<p>
(Authorized Signatory)
</p>


<br><br>

<p>
<strong>Candidate / Authorized Representative:</strong><br>
I acknowledge receipt of the finalized nomination forms and this Observation Record. I affirm that I have reviewed the contents and that all disclosures are true and accurate.
</p>


<br><br>

<p>
Signature: <span class="signature-line"></span>
</p>

<br>

<p>
Name: <span class="signature-line"></span>
</p>

<br>

<p>
Date / Time: <span class="signature-line"></span>
</p>


</div>


</body>
</html>