require('./bootstrap');

(function () {
    setInterval(function () {
        async function loadOperations() {
            const lastOperations = await fetch(`/last-operations`);
            return await lastOperations.json()
        }

        loadOperations().then(operations => {
            let operationsTable = document.getElementById("operations-table").getElementsByTagName('tbody')[0];
            operationsTable.innerHTML = "";
            let tbodyRef = document.getElementById('operations-table').getElementsByTagName('tbody')[0];

            for (const [key, value] of Object.entries(operations.data)) {
                let newRow = tbodyRef.insertRow();
                for (const [key1, value1] of Object.entries(value)) {
                    let newCell = newRow.insertCell();
                    let newText = document.createTextNode(value1);
                    newCell.appendChild(newText);
                }
            }
            document.getElementById('main-balance').innerText = operations.meta.balance;
        });
    }, refreshRate);
})();
