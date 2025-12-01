<?php require_once __DIR__ . '/partials/header.php'; ?>

<?php
/** @var BookingViewModel $viewModel */
$showing = $viewModel->getShowing();
?>

<style>
    /* Theme tokens that match your site */
    :root {
        --neon-yellow: #FFDF00;
        --neon-cyan: #00e7ec;
        --neon-pink: #FE04FF;
        --muted: #0f1720; /* dark background */
        --panel: #0b1220;
    }

    /* Small seat visuals (we use rounded-2xl to mimic comfy seats) */
    .seat {
        width: 36px;
        height: 28px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: inset 0 -2px 0 rgba(0, 0, 0, .4);
        transition: transform .12s ease, box-shadow .12s ease;
    }

    /* Neon focus for keyboard users */
    .seat:focus {
        outline: 3px solid rgba(0, 231, 236, .25);
    }

    /* Seat states */
    .seat--available {
        background: linear-gradient(180deg, #1f2937, #111827);
        border: 2px solid rgba(255, 255, 255, .04);
    }

    .seat--sold {
        background: linear-gradient(180deg, #a62020, #7b0f0f);
        color: white;
        border: 2px solid rgba(0, 0, 0, .6);
        cursor: not-allowed;
        box-shadow: 0 4px 12px rgba(167, 32, 32, .08);
    }

    .seat--selected {
        background: linear-gradient(180deg, var(--neon-yellow), #e6d300);
        color: #111;
        border: 2px solid rgba(255, 255, 255, .9);
        transform: translateY(-6px);
        box-shadow: 0 10px 30px rgba(255, 223, 0, .18);
    }

    .seat--hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 22px rgba(0, 0, 0, .25);
    }

    /* Screen bar */
    .screen {
        height: 10px;
        background: linear-gradient(90deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .02));
        border-radius: 6px;
        position: relative;
    }

    .screen-label {
        position: absolute;
        top: -28px;
        left: 50%;
        transform: translateX(-50%);
        background: transparent;
        color: var(--neon-cyan);
        font-weight: 700;
        letter-spacing: 2px;
    }

    .screen-wrap {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Nice subtle glass panel */
    .panel {
        background: linear-gradient(180deg, rgba(255, 255, 255, .02), rgba(0, 0, 0, .35));
        border: 1px solid rgba(255, 255, 255, .03);
    }

</style>
</head>
<body class="min-h-screen bg-black text-white" style="font-family:Inter,ui-sans-serif,system-ui,sans-serif">
<!-- Top header (uses your hero palette) -->
<!-- Top info bar: movie + hall -->
<header class="py-6 px-6 border-b border-[#0b1220]">
    <div class="container mx-auto flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-2xl font-extrabold text-[var(--neon-yellow)]"><?php echo safeString($showing->getMovie()->getTitle()); ?></h1>
            <span class="text-sm text-gray-300"><?php echo safeString($showing->getMovie()->getLength()); ?> minutes • <?php echo safeString(implode(", ", $showing->getMovie()->getGenres())); ?> • <?php echo safeString($showing->getMovie()->getReleaseYear()); ?></span>
        </div>
        <div class="text-sm text-gray-300">Hall: <span
                    class="font-semibold text-[#00e7ec]"><?php echo safeString($showing->getHall()->getNumber()); ?></span>
        </div>
    </div>
</header>

<main class="container mx-auto px-6 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left: ticket controls -->
        <aside class="panel p-6 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-[#00e7ec]">Choose tickets</h2>

            <div class="price-group mt-6 space-y-4" data-price="<?php echo $showing->getPrice(); ?>">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="font-semibold">Normal</div>
                        <div class="text-xs text-gray-400"><?php echo $showing->getPrice() ?> DKK incl. fee</div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button id="dec-normal" class="px-2 py-1 rounded-md bg-gray-800" onclick="decreaseTicketCount('#count-normal')">−</button>
                        <div id="count-normal" class="w-8 text-center">2</div>
                        <button id="inc-normal" class="px-2 py-1 rounded-md bg-[#00e7ec] text-black" onclick="increaseTicketCount('#count-normal')">+</button>
                    </div>
                </div>

                <div class="mt-4 text-sm text-gray-400">Select the same number of seats as tickets. Your selected seats
                    appear to the right.
                </div>
            </div>

            <div class="mt-6 border-t border-[#0b1220] pt-4 flex items-center justify-between">
                <div>
                    <div class="text-xs text-gray-400">Selected tickets</div>
                    <div id="total-count" class="font-bold text-lg">2</div>
                </div>
                <div>
                    <div class="text-xs text-gray-400">Price</div>
                    <div id="total-price-view" class="font-bold text-lg">DKK 300</div>
                </div>
            </div>

        </aside>

        <!-- Middle: seat map -->
        <section class="lg:col-span-2 panel p-6 rounded-xl">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-2xl font-bold text-[#FFDF00]">Choose seats</h3>
                </div>
            </div>

            <div class="mb-6">
                <div class="screen-wrap mb-3">
                    <div class="screen w-full mx-auto"></div>
                    <div class="screen-label">SCREEN</div>
                </div>

                <!-- Seats grid container -->

                <div id="seat-map" class="w-full flex flex-col items-center gap-3">
                    <?php foreach ($viewModel->getSeatMap() as $number => $row): ?>
                        <div class="seat-row flex items-center gap-3">
                            <div class="w-6 text-sm text-gray-300"><?php echo $number; ?></div>
                            <?php /** @var Seat $seat */ ?>
                            <?php foreach ($row as $seat): ?>
                                <?php $isSold = array_key_exists($seat->getSeatID(), $viewModel->getSoldSeatMap()) ?>
                                <button class="seat seat--available <?php echo $isSold ? "seat--sold" : "" ?>"
                                        data-id="<?php echo safeString($seat->getSeatID()); ?>"
                                        data-seat="<?php echo safeString($seat->getNumber()); ?>"
                                        data-row="<?php echo safeString($seat->getRowNumber()); ?>"
                                        onmouseenter="onSeatHover(<?php echo $seat->getRowNumber(); ?>, <?php echo $seat->getNumber(); ?>, this)"
                                        onclick="onSeatClick(<?php echo $seat->getRowNumber(); ?>, <?php echo $seat->getNumber(); ?>)"
                                        <?php echo $isSold ? "disabled" : "" ?>
                                >
                                    <?php echo safeString($seat->getNumber()); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Legend -->
                <div class="mt-6 flex items-center gap-6 text-sm text-gray-300">
                    <div class="flex items-center gap-2"><span class="seat seat--sold"
                                                               style="width:18px;height:14px"></span> Sold
                    </div>
                    <div class="flex items-center gap-2"><span class="seat seat--selected"
                                                               style="width:18px;height:14px;background:linear-gradient(180deg,var(--neon-yellow),#e6d300);border:1px solid rgba(0,0,0,.1);"></span>
                        Your seats
                    </div>
                </div>
            </div>

            <!-- Selected seats summary & next button -->
            <div class="flex items-center justify-between border-t border-[#0b1220] pt-4">
                <div class="text-sm text-gray-300">Selected seats: <span id="selected-list"
                                                                         class="font-semibold text-white">Row 4 • 5</span>
                </div>
                <div class="flex items-center gap-4">
                    <button id="reset-btn" class="px-4 py-2 rounded-md bg-gray-800">Reset</button>
                    <form method="POST" action="<?php echo generateUrl('booking'); ?>" id="payment-form">
                        <input type="hidden" name="showingId"
                               value="<?php echo safeString($showing->getShowingID()); ?>">
                        <input type="hidden" name="seats" id="seats-input" value="">
                        <input type="hidden" name="totalPrice" id="total-price" value="">
                        <input type="hidden" name="numberOfTickets" id="number-of-tickets" value="2">
                        <input type="hidden" name="unitPrice" id="unit-price"
                               value="<?php echo safeString($showing->getPrice()); ?>">
                        <button id="next-btn" class="px-6 py-2 rounded-md bg-[#00e7ec] text-black font-semibold">Next
                        </button>
                    </form>
                </div>
            </div>

        </section>
    </div>
</main>

<script>
    let hoverBlock = null;
    // store selected seats by their data-id (unique seat ID) instead of "row:seat"
    const selected = new Set();

    const totalPriceField = document.getElementById('total-price');
    const numberOfTicketsField = document.getElementById('number-of-tickets');
    const unitPriceField = document.getElementById('unit-price');

    function getTotalTickets() {
        // derive ticket count from the hidden field so seat selection logic uses the current ticket count
        const n = parseInt(numberOfTicketsField.value, 10);
        return isNaN(n) ? 0 : n;
    }

    function onSeatHover(rowId, colIndex, btn) {
        const len = getTotalTickets();
        if (len === 0) return; // nothing to highlight
        const block = findContiguousBlock(rowId, colIndex, len);
        highlightBlock(block);
    }

    function clearSelections() {
        // Deselect previous selection using data-id stored in the `selected` Set
        selected.forEach(id => {
            const el = document.querySelector(`.seat[data-id="${id}"]`);
            if (el) el.classList.remove('seat--selected');
        });
        selected.clear();

        // reset UI where relevant
        const listEl = document.getElementById('selected-list');
        if (listEl) listEl.textContent = '';

        const seatsInput = document.getElementById('seats-input');
        if (seatsInput) seatsInput.value = '';
    }

    function onSeatClick(rowId, colIndex) {
        const len = getTotalTickets();
        if (len === 0) {
            alert('Please choose ticket quantity first.');
            return;
        }
        const block = findContiguousBlock(rowId, colIndex, len);
        if (!block) {
            // no contiguous block available including this seat
            alert('Cannot find a contiguous group of seats here. Try another spot.');
            return;
        }
        clearSelections();

        // Select new block using the seat attributes that exist in the markup
        for (let c = block.start; c <= block.end; c++) {
            const el = document.querySelector(`.seat[data-row="${block.row}"][data-seat="${c}"]`);
            if (el && !el.classList.contains('seat--sold')) {
                el.classList.add('seat--selected');
                // store selection by the unique data-id attribute
                const sid = el.getAttribute('data-id');
                if (sid) selected.add(sid);
            }
        }

        // Update UI: selected list and hidden inputs (store seat IDs)
        const listEl = document.getElementById('selected-list');
        if (listEl) {
            const items = Array.from(selected).map(id => {
                const el = document.querySelector(`.seat[data-id="${id}"]`);
                if (!el) return id;
                return `Row ${el.getAttribute('data-row')} • ${el.getAttribute('data-seat')}`;
            });
            listEl.textContent = items.join(', ');
        }

        const seatsInput = document.getElementById('seats-input');
        if (seatsInput) seatsInput.value = Array.from(selected).join(',');

        // update number of tickets stored
        if (numberOfTicketsField) numberOfTicketsField.value = selected.size;

        // ensure total price is up-to-date
        updateTotal();
    }

    function findContiguousBlock(rowId, colIndex, len) {
        if (len <= 0) return null;

        const seatMap = document.querySelector('#seat-map');
        if (!seatMap) return null;

        // Get all row containers and find the one whose left label matches rowId
        const rows = Array.from(seatMap.querySelectorAll('.seat-row'));
        const rowEl = rows.find(r => {
            const labelDiv = r.querySelector(':scope > div');
            if (!labelDiv) return false;
            return labelDiv.textContent.trim() === String(rowId);
        });
        if (!rowEl) return null;

        // Collect seat buttons in this row and determine min/max seat numbers
        const seats = Array.from(rowEl.querySelectorAll('.seat'));
        if (seats.length === 0) return null;
        const seatNums = seats
            .map(b => parseInt(b.getAttribute('data-seat'), 10))
            .filter(n => !isNaN(n))
            .sort((a, b) => a - b);
        const minSeat = seatNums[0];
        const maxSeat = seatNums[seatNums.length - 1];

        // Helper to test whether a seat is sold/unavailable using the DOM
        function isSeatSold(n) {
            const btn = rowEl.querySelector(`.seat[data-seat="${n}"]`);
            return !btn || btn.disabled || btn.classList.contains('seat--sold');
        }

        // Validate block [s..e] using the actual DOM seats
        function blockValid(s, e) {
            if (s < minSeat || e > maxSeat) return false;
            for (let c = s; c <= e; c++) {
                // every seat must exist and not be sold/disabled
                const btn = rowEl.querySelector(`.seat[data-seat="${c}"]`);
                if (!btn || isSeatSold(c)) return false;
            }
            return true;
        }

        // Center the block around the hovered column where possible
        const halfLeft = Math.floor((len - 1) / 2);
        const centerStart = colIndex - halfLeft;

        const maxOffset = (maxSeat - minSeat + 1);
        for (let offset = 0; offset <= maxOffset; offset++) {
            // try shifted left
            let s = centerStart - offset;
            let e = s + len - 1;
            if (blockValid(s, e)) return {row: rowId, start: s, end: e};
            // try shifted right
            s = centerStart + offset;
            e = s + len - 1;
            if (blockValid(s, e)) return {row: rowId, start: s, end: e};
        }

        return null;
    }

    function highlightBlock(block) {
        clearHoverBlock();
        if (!block) return;
        hoverBlock = block;
        for (let c = block.start; c <= block.end; c++) {
            // Use data-row and data-seat attributes from the DOM (no formatSeatId)
            const sel = document.querySelector(`.seat[data-row="${block.row}"][data-seat="${c}"]`);
            if (sel && !sel.classList.contains('seat--sold')) sel.classList.add('seat--hover');
        }
    }

    function clearHoverBlock() {
        if (!hoverBlock) return;
        for (let c = hoverBlock.start; c <= hoverBlock.end; c++) {
            const sel = document.querySelector(`.seat[data-row="${hoverBlock.row}"][data-seat="${c}"]`);
            if (sel) sel.classList.remove('seat--hover');
        }
        hoverBlock = null;
    }

    function increaseTicketCount(counterId) {
        let counter = document.querySelector(counterId);
        let count = parseInt(counter.textContent, 10);
        count += 1;
        counter.textContent = count;
        console.log(numberOfTicketsField);
        if (numberOfTicketsField) numberOfTicketsField.value = count;
        updateTotal();
        clearSelections();
    }

    function decreaseTicketCount(counterId) {
        let counter = document.querySelector(counterId);
        let count = parseInt(counter.textContent, 10);
        if (count > 0) {
            count -= 1;
            counter.textContent = count;
            if (numberOfTicketsField) numberOfTicketsField.value = count;
            updateTotal();
            clearSelections();
        }
    }

    function updateTotal() {
        var numberOfTickets = parseInt(numberOfTicketsField.value);
        var unitPrice = parseFloat(unitPriceField.value);
        if (isNaN(numberOfTickets) || isNaN(unitPrice)) return;
        if (totalPriceField) {
            // totalPriceField is a hidden input; update its value
            totalPriceField.value = numberOfTickets * unitPrice;

            // update the total count display
            const totalCountView = document.getElementById('total-count');
            if (totalCountView) totalCountView.textContent = numberOfTickets;

            // also update visible price display if present
            const totalPriceView = document.getElementById('total-price-view');
            if (totalPriceView) totalPriceView.textContent = 'DKK ' + (numberOfTickets * unitPrice);
        }
    }

    updateTotal();
</script>


<?php require_once __DIR__ . '/partials/footer.php'; ?>
