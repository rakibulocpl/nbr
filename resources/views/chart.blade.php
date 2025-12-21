{{--                    <div class="mt-8 space-y-10">--}}

{{--                        --}}{{-- 🔹 Section Title --}}
{{--                        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6 border-b pb-2">--}}
{{--                            Financial Overview Dashboard--}}
{{--                        </h2>--}}

{{--                        --}}{{-- 🔸 Grid Layout (Responsive) --}}
{{--                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">--}}

{{--                            --}}{{-- 🧮 Financial Analysis (Yearly / Monthly) --}}
{{--                            <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-6 bg-white dark:bg-gray-900 shadow-sm">--}}
{{--                                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">--}}
{{--                                    Financial Analysis (Yearly / Monthly)--}}
{{--                                </h3>--}}

{{--                                <div class="flex flex-wrap justify-between items-center mb-3">--}}
{{--                                    <p class="text-sm text-gray-500 dark:text-gray-400">--}}
{{--                                        Click a year bar to view its monthly breakdown.--}}
{{--                                    </p>--}}
{{--                                    <button id="backToYearly"--}}
{{--                                            class="hidden bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-2 rounded-md transition">--}}
{{--                                        ← Back to Yearly--}}
{{--                                    </button>--}}
{{--                                </div>--}}

{{--                                <canvas id="financialChart" height="200"></canvas>--}}
{{--                            </div>--}}

{{--                            --}}{{-- 🧾 Transaction Type Pie Chart --}}
{{--                            <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-6 bg-white dark:bg-gray-900 shadow-sm">--}}
{{--                                <div class="flex justify-between items-center mb-4">--}}
{{--                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">--}}
{{--                                        Transaction Type Breakdown--}}
{{--                                    </h3>--}}

{{--                                    <select id="txnYearSelect"--}}
{{--                                            class="border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg px-3 py-2 text-sm text-gray-800 dark:text-white focus:border-blue-400 focus:ring-1 focus:ring-blue-100 transition">--}}
{{--                                        <option value="all">All Years</option>--}}
{{--                                        <option value="2022-2023">2022–2023</option>--}}
{{--                                        <option value="2023-2024" selected>2023–2024</option>--}}
{{--                                        <option value="2024-2025">2024–2025</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}

{{--                                <canvas id="txnTypePieChart" height="220"></canvas>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        --}}{{-- 🏦 Top 10 Transactions Combined Chart (Full Width) --}}
{{--                        --}}{{-- 🏦 Top 10 Transactions Combined Chart (Compact) --}}
{{--                        <div class="border border-gray-200 dark:border-gray-700 rounded-2xl p-5 bg-white dark:bg-gray-900 shadow-sm">--}}
{{--                            <div class="flex justify-between items-center mb-3">--}}
{{--                                <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">--}}
{{--                                    Top 10 Transactions--}}
{{--                                </h3>--}}
{{--                                <select id="combinedTopTxnSelect"--}}
{{--                                        class="border border-gray-300 dark:border-gray-600 dark:bg-gray-800 rounded-lg px-2 py-1.5 text-xs text-gray-800 dark:text-white focus:border-blue-400 focus:ring-1 focus:ring-blue-100 transition">--}}
{{--                                    <option value="all" selected>All Years</option>--}}
{{--                                    <option value="2022-2023">2022–2023</option>--}}
{{--                                    <option value="2023-2024">2023–2024</option>--}}
{{--                                    <option value="2024-2025">2024–2025</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}

{{--                            <canvas id="combinedTopTxnChart" height="160"></canvas>--}}
{{--                        </div>--}}

{{--                    </div>--}}


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('financialChart');
        const backBtn = document.getElementById('backToYearly');

        // Demo data
        const demoData = {
            "2022-2023": {
                months: ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                deposits: [120000, 95000, 150000, 130000, 110000, 90000, 170000, 200000, 160000, 180000, 140000, 220000],
                withdrawals: [80000, 70000, 90000, 85000, 95000, 60000, 110000, 100000, 95000, 105000, 85000, 120000],
            },
            "2023-2024": {
                months: ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                deposits: [180000, 160000, 200000, 190000, 210000, 250000, 230000, 220000, 260000, 240000, 270000, 280000],
                withdrawals: [120000, 110000, 130000, 100000, 95000, 115000, 125000, 100000, 150000, 130000, 110000, 140000],
            },
            "2024-2025": {
                months: ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                deposits: [200000, 180000, 190000, 210000, 220000, 240000, 250000, 270000, 280000, 260000, 300000, 310000],
                withdrawals: [100000, 95000, 110000, 105000, 120000, 115000, 130000, 125000, 135000, 140000, 150000, 145000],
            }
        };

        // Compute yearly totals
        const years = Object.keys(demoData);
        const yearlyDeposits = years.map(y => demoData[y].deposits.reduce((a,b)=>a+b,0));
        const yearlyWithdrawals = years.map(y => demoData[y].withdrawals.reduce((a,b)=>a+b,0));

        let currentView = 'yearly';
        let chart;

        function renderYearlyChart() {
            currentView = 'yearly';
            backBtn.classList.add('hidden');

            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: years,
                    datasets: [
                        {
                            label: 'Total Deposits',
                            data: yearlyDeposits,
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderRadius: 8,
                        },
                        {
                            label: 'Total Withdrawals',
                            data: yearlyWithdrawals,
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderRadius: 8,
                        }
                    ]
                },
                options: {
                    onClick: (e, elements) => {
                        if (elements.length > 0) {
                            const index = elements[0].index;
                            const year = years[index];
                            renderMonthlyChart(year);
                        }
                    },
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Yearly Deposit vs Withdrawal Overview' }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        function renderMonthlyChart(year) {
            currentView = 'monthly';
            backBtn.classList.remove('hidden');
            const data = demoData[year];

            if (chart) chart.destroy();
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.months,
                    datasets: [
                        {
                            label: 'Deposits',
                            data: data.deposits,
                            backgroundColor: 'rgba(34, 197, 94, 0.8)',
                            borderRadius: 6,
                        },
                        {
                            label: 'Withdrawals',
                            data: data.withdrawals,
                            backgroundColor: 'rgba(239, 68, 68, 0.8)',
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: `Monthly Breakdown (${year})` }
                    },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        backBtn.addEventListener('click', renderYearlyChart);
        renderYearlyChart();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const txnCtx = document.getElementById('txnTypePieChart');
        const txnYearSelect = document.getElementById('txnYearSelect');

        // ✅ Demo dataset — transaction type totals by year
        const txnDemoData = {
            "2022-2023": { cash: 420000, cheque: 280000, transfer: 180000, other: 100000 },
            "2023-2024": { cash: 510000, cheque: 320000, transfer: 250000, other: 120000 },
            "2024-2025": { cash: 600000, cheque: 350000, transfer: 400000, other: 150000 },
        };

        // Combine all years
        const txnAllYears = Object.values(txnDemoData).reduce((acc, year) => {
            for (const [key, val] of Object.entries(year)) acc[key] = (acc[key] || 0) + val;
            return acc;
        }, {});

        // Build dataset for selected year
        function getTxnData(year) {
            const data = year === 'all' ? txnAllYears : txnDemoData[year];
            return {
                labels: ['Cash', 'Cheque', 'Transfer', 'Other'],
                datasets: [{
                    data: [data.cash, data.cheque, data.transfer, data.other],
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',   // Cash - green
                        'rgba(59, 130, 246, 0.8)',   // Cheque - blue
                        'rgba(234, 179, 8, 0.8)',    // Transfer - yellow
                        'rgba(239, 68, 68, 0.8)'     // Other - red
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            };
        }

        // Render Chart
        let txnChart = new Chart(txnCtx, {
            type: 'pie',
            data: getTxnData('2023-2024'),
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' },
                    title: {
                        display: true,
                        text: 'Transaction Type Distribution (2023–2024)'
                    }
                }
            }
        });

        // Update on year change
        txnYearSelect.addEventListener('change', function () {
            const year = this.value;
            txnChart.data = getTxnData(year);
            txnChart.options.plugins.title.text =
                year === 'all'
                    ? 'Transaction Type Distribution (All Years)'
                    : `Transaction Type Distribution (${year})`;
            txnChart.update();
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('combinedTopTxnChart').getContext('2d');
        const yearSelect = document.getElementById('combinedTopTxnSelect');

        // ✅ Demo data with transaction type
        const topYearData = {
            "all": [
                { name: "ABC Traders Ltd.", amount: 980000, type: "Deposit" },
                { name: "Global ICT Ltd.", amount: 870000, type: "Withdrawal" },
                { name: "Digital Soft BD", amount: 860000, type: "Deposit" },
                { name: "Smart Solutions", amount: 850000, type: "Withdrawal" },
                { name: "Tech Valley", amount: 830000, type: "Deposit" },
                { name: "NextGen IT", amount: 820000, type: "Deposit" },
                { name: "CyberLink BD", amount: 810000, type: "Withdrawal" },
                { name: "Ecom Digital", amount: 800000, type: "Deposit" },
                { name: "AI Hub Ltd.", amount: 790000, type: "Withdrawal" },
                { name: "Fintech Plus", amount: 780000, type: "Deposit" },
            ],
            "2022-2023": [
                { name: "Alpha Systems", amount: 650000, type: "Withdrawal" },
                { name: "CloudNet BD", amount: 610000, type: "Deposit" },
                { name: "Tech Hive", amount: 580000, type: "Withdrawal" },
                { name: "CyberLink BD", amount: 540000, type: "Deposit" },
                { name: "Fintech Plus", amount: 530000, type: "Deposit" },
                { name: "BD Logic", amount: 500000, type: "Withdrawal" },
                { name: "Ecom Digital", amount: 480000, type: "Deposit" },
                { name: "AI Hub Ltd.", amount: 470000, type: "Withdrawal" },
                { name: "Smart City Corp", amount: 460000, type: "Deposit" },
                { name: "Innovate BD", amount: 450000, type: "Deposit" },
            ],
            "2023-2024": [
                { name: "Global ICT Ltd.", amount: 970000, type: "Deposit" },
                { name: "Digital Soft BD", amount: 940000, type: "Deposit" },
                { name: "Tech Valley", amount: 910000, type: "Withdrawal" },
                { name: "NextGen IT", amount: 880000, type: "Deposit" },
                { name: "CyberLink BD", amount: 850000, type: "Withdrawal" },
                { name: "Ecom Digital", amount: 830000, type: "Deposit" },
                { name: "AI Hub Ltd.", amount: 800000, type: "Deposit" },
                { name: "Fintech Plus", amount: 780000, type: "Withdrawal" },
                { name: "Smart Solutions", amount: 760000, type: "Deposit" },
                { name: "Projonmo Systems", amount: 740000, type: "Deposit" },
            ],
            "2024-2025": [
                { name: "Digital Link BD", amount: 980000, type: "Withdrawal" },
                { name: "AI Hub Ltd.", amount: 950000, type: "Deposit" },
                { name: "Smart City Corp", amount: 910000, type: "Deposit" },
                { name: "Tech Valley", amount: 880000, type: "Withdrawal" },
                { name: "CyberLink BD", amount: 850000, type: "Deposit" },
                { name: "Fintech Plus", amount: 820000, type: "Deposit" },
                { name: "Ecom Digital", amount: 800000, type: "Withdrawal" },
                { name: "NextGen IT", amount: 780000, type: "Deposit" },
                { name: "Digital Soft BD", amount: 750000, type: "Deposit" },
                { name: "Innovate BD", amount: 720000, type: "Withdrawal" },
            ]
        };

        function getYearData(year) {
            const data = topYearData[year];
            return {
                labels: data.map(item => item.name),
                datasets: [{
                    label: 'Transaction Amount (BDT)',
                    data: data.map(item => item.amount),
                    backgroundColor: data.map(item =>
                        item.type === 'Deposit'
                            ? 'rgba(16, 185, 129, 0.8)'  // green
                            : 'rgba(239, 68, 68, 0.8)'   // red
                    ),
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            };
        }

        // ✅ Initialize Chart
        let combinedChart = new Chart(ctx, {
            type: 'bar',
            data: getYearData('all'),
            options: {
                responsive: true,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Top 10 Transactions (All Years)',
                        font: { size: 14 }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const type = topYearData[yearSelect.value][context.dataIndex].type;
                                return `${context.formattedValue} BDT (${type})`;
                            }
                        }
                    }
                },
                scales: {
                    x: { beginAtZero: true, ticks: { font: { size: 10 } } },
                    y: { ticks: { font: { size: 10 } } }
                }
            }
        });

        // ✅ Handle Year Change
        yearSelect.addEventListener('change', function () {
            const selectedYear = this.value;
            combinedChart.data = getYearData(selectedYear);
            combinedChart.options.plugins.title.text =
                selectedYear === 'all'
                    ? 'Top 10 Transactions (All Years)'
                    : `Top 10 Transactions (${selectedYear})`;
            combinedChart.update();
        });
    });
</script>
