require('./bootstrap');

document.getElementById("th-date").onclick = function () {
    let url = new URL(location.href);
    let params = new URLSearchParams(url.search);

    if (params.has('order_by') === false) {
        params.append('order_by', '-date');
    } else if (params.get("order_by") === '-date') {
        params.set('order_by', 'date');
    } else if (params.get("order_by") === 'date') {
        params.delete('order_by');
    }
    const new_url = new URL(`${location.origin}${location.pathname}?${params.toString()}`);
    location.assign(new_url);
};

document.getElementById("op-search-btn").onclick = function () {
    let search = document.getElementById("op-search-inp").value;
    let url = new URL(location.href);
    let params = new URLSearchParams(url.search);

    params.set('description', search);
    const new_url = new URL(`${location.origin}${location.pathname}?${params.toString()}`);
    location.assign(new_url);
};
