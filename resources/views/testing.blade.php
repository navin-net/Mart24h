<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banking App - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/react@18/umd/react.development.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/react-dom@18/umd/react-dom.development.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/babel-standalone@6/babel.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans">
  <div id="root"></div>
  <script type="text/babel">
    const { useState } = React;

    // Mock data for recent transactions
    const recentTransactions = [
      { id: 1, date: "2025-08-27", description: "Grocery Store", amount: -45.99 },

    ];

    // Home Page (Dashboard) Component
    function HomePage() {
      return (
        <div class="flex flex-col h-screen">
          {/* Header */}
          <header class="bg-blue-600 text-white p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold">Welcome Back!</h1>
            <button class="text-white">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
          </header>

          {/* Main Content */}
          <main class="flex-1 p-4 space-y-4 overflow-y-auto">
            {/* Account Balance Card */}
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h2 class="text-lg font-semibold text-gray-700">Account Balance</h2>
              <p class="text-3xl font-bold text-blue-600">$5,234.67</p>
              <p class="text-sm text-gray-500">Available Balance</p>
            </div>

            {/* Quick Actions */}
            <div class="grid grid-cols-3 gap-4">
              <button class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 flex flex-col items-center">
                <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Transfer
              </button>
              <button class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 flex flex-col items-center">
                <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Deposit
              </button>
              <button class="bg-blue-600 text-white p-4 rounded-lg hover:bg-blue-700 flex flex-col items-center">
                <svg class="w-6 h-6 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l-3-3m0 0l3-3m-3 3h12" />
                </svg>
                Pay Bills
              </button>
            </div>

            {/* Recent Transactions */}
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h2 class="text-lg font-semibold text-gray-700 mb-4">Recent Transactions</h2>
              {recentTransactions.map((txn) => (
                <div key={txn.id} class="flex justify-between py-2 border-b last:border-b-0">
                  <div>
                    <p class="font-medium">{txn.description}</p>
                    <p class="text-sm text-gray-500">{txn.date}</p>
                  </div>
                  <p class={txn.amount < 0 ? "text-red-600" : "text-green-600"}>
                    ${Math.abs(txn.amount).toFixed(2)}
                  </p>
                </div>
              ))}
              <button class="text-blue-600 text-sm mt-4 hover:underline">View All Transactions</button>
            </div>
          </main>

          {/* Footer */}
          <footer class="bg-gray-800 text-white p-4 text-center">
            <p>&copy; 2025 Banking App</p>
          </footer>
        </div>
      );
    }

    // Render the app
    ReactDOM.render(<HomePage />, document.getElementById("root"));
  </script>
</body>
</html>