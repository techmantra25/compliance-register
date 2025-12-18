<div>
    
<style>
@import url('https://fonts.googleapis.com/css2?family=Latin+Modern+Roman:ital,wght@0,400;0,700;1,400&display=swap');

@page {
    size: A4;
    margin: 15mm; 
    padding: 5px;
}

/* Remove browser header/footer */
@media print {
    @page { margin: 15mm; }
    body {
        margin: 0;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
}

.center { text-align: center; }
.bold { font-weight: bold; }

/* Inputs */
input[type="text"],
input[type="date"],
input[type="time"] {
    border: none;
    border-bottom: 1px dotted #000;
    font-family: "Latin Modern Roman", "Computer Modern Serif", serif;
    font-size: 13px;              /* ↓ reduced */
    width: 240px;
    font-weight: 700;
}


input.small { width: 110px; }
input.medium { width: 170px; }
input.large { width: 320px; }

input:focus { outline: none; }

/* Paragraph spacing reduced */
p {
    margin: 6px 0;
}

/* Signature spacing */
.signature {
    text-align: right;
    margin-top: 12px;             /* ↓ reduced */
    margin-bottom: 8px;
}

/* Divider */
.rule {
    border-top: 1px solid #000;
    margin: 8px 0;               /* ↓ reduced */
}

/* Notes & footnotes */
.note {
    font-size: 13px;
}

.list {
    font-size: 13px;
    /* margin-top: 8px;              ↓ reduced */
}

.list p {
    margin: 4px 0;
}
.card{
    font-family: "Latin Modern Roman", "Computer Modern Serif", serif;
    font-size: 13px;
    line-height: 1.25;
    color: #000;
    margin: 0;
}
input[type="date"]::-webkit-calendar-picker-indicator,
input[type="time"]::-webkit-calendar-picker-indicator {
    opacity: 0;
    cursor: pointer;
}
/* Buttons hidden on print */
@media print {
    .d-print-none {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
    }
      input[type="date"]::-webkit-calendar-picker-indicator,
        input[type="time"]::-webkit-calendar-picker-indicator {
            display: none;
            -webkit-appearance: none;
        }

        input[type="date"],
        input[type="time"] {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: textfield;
        }
}

</style>

<div style="padding: 25px;font-weight: 500;color: #000;" class="card">
    <!-- Header -->
    <div class="center" style="font-style: italic">Conduct of Elections Rules, 1961</div>
    <div class="center">(Statutory Rules and Orders)</div>

    <!-- Title -->
    <div class="center" style="margin-top:20px;">
        <div class="bold" style="font-size:16px;">FORM 5</div>
        <div>[See rule 9(1)]</div>
        <div class="bold" style="margin-top:10px;">NOTICE OF WITHDRAWAL OF CANDIDATURE</div>
    </div>

    <div class="center" style="margin-top:20px;">
        <!-- Form Body -->
        <p style="font-style:italic">
            Election to the*
            <input type="text" class="medium" wire:model.defer="election_to">
        </p>
    </div>

    <p>The Returning Officer,</p>

    <p>
        I,
        <input type="text" class="medium" wire:model.defer="candidate_name" readonly>,
        a 1[candidate validly nominated] at the above election do hereby give notice
        that I withdraw my candidature.
    </p>

    <p>
        Place
        <input type="text" class="medium" wire:model.defer="place">
    </p>

    <p>
        Date
        <input type="date" class="small" wire:model.defer="candidate_date">
    </p>

    <div class="signature">
        {{ $candidate_signature }}
    </div>

    <p style="margin-top:25px;">
        This notice was delivered to me at my office at
        <input type="time" class="small" wire:model.defer="office_hour"> (hour) on
        <input type="date" class="small" wire:model.defer="office_date"> (date) by
        <input type="text" class="medium" wire:model.defer="delivered_by_name"> (name), the+
        <input type="text" class="medium" wire:model.defer="delivered_by_role">
    </p>

    <p>
        Date
        <input type="date" class="small" wire:model.defer="ro_date">
    </p>

    <div class="signature">
        {{ $ro_signature }}
    </div>

    <div class="rule"></div>

    <!-- Receipt Section -->
    <div class="center" style="font-style: italic">Receipt for Notice of Withdrawal</div>
    <div class="center note">(To be handed over to the person delivering the notice)</div>

    <p style="margin-top:20px;">
        The notice of withdrawal of candidature by
        <input type="text" class="medium" wire:model.defer="receipt_candidate_name">,
        a 1[validly nominated candidate] at the election to the*
        <input type="text" class="large" wire:model.defer="receipt_election_to">
        was delivered to me by the+
        <input type="text" class="medium" wire:model.defer="receipt_delivered_by">
        at my office at
        <input type="time" class="small" wire:model.defer="receipt_office_hour"> (hour) on
        <input type="date" class="small" wire:model.defer="receipt_office_date"> (date).
    </p>

    <div class="signature">
        {{ $receipt_ro_signature }}
    </div>

    <div class="rule"></div>

    <!-- Footnotes (NOW EDITABLE) -->
    <div class="list">
        <p>*Here insert one of the following alternatives as may be appropriate:—</p>
        <p>(1) House of the People from the <input type="text" class="medium" wire:model.defer="footnote_hp_constituency"> constituency.</p>
        <p>(2) Legislative Assembly from the <input type="text" class="medium" wire:model.defer="footnote_la_constituency"> constituency.</p>
        <p>(3) Council of States by the elected members of the Legislative Assembly of <input type="text" class="medium" wire:model.defer="footnote_cs_state"> (State).</p>
        <p>(4) Council of States by the members of the electoral college of <input type="text" class="medium" wire:model.defer="footnote_cs_ut"> (Union Territory).</p>
        <p>(5) Legislative Council by the members of the Legislative Assembly.</p>
        <p>(6) Legislative Council from the <input type="text" class="medium" wire:model.defer="footnote_lc_constituency"> constituency.</p>
    </div>

    <div class="list">
        <p>+Here insert one of the following alternatives as may be appropriate:—</p>
        <p>(1) Candidate.</p>
        <p>(2) Candidate's proposer authorised in writing.</p>
        <p>(3) Candidate's election agent authorised in writing.</p>
    </div>

    <div class="rule"></div>
    <div class="list !mt-0">
        <p>1. Subs. by Notifn. No. S.O. 565(E), dated the 4th August, 1984.</p>
    </div>

    <!-- Buttons -->
    <div class="mt-4 d-print-none">
        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>
   <div class="text-center mt-2 d-print-none">
        <a href="{{ route('admin.candidates.contacts') }}" class="btn btn-secondary">
            ← Back
        </a>

        <button class="btn btn-success" wire:click="save">
            Save
        </button>

        <button class="btn btn-primary" wire:click="saveAndPrint">
            Save & Print
        </button>
    </div>

</div>

<script>
window.addEventListener('print-form5', () => {
    setTimeout(() => window.print(), 300);
});
</script>
</div>
