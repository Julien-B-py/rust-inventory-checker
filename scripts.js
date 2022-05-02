const sort = document.querySelector("select");

let items = Array.from(document.querySelectorAll(".item"));

const sortByNameAsc = (a, b) => {
    return a.querySelector("h2").textContent.toLowerCase().localeCompare(b.querySelector("h2").textContent.toLowerCase());
}

const sortByNameDesc = (a, b) => {
    return b.querySelector("h2").textContent.toLowerCase().localeCompare(a.querySelector("h2").textContent.toLowerCase());
}

// const sortByPriceAsc = (a, b) => {
//     const aPrice = Number(a.querySelector("p").textContent.toLowerCase().split('€')[0]);
//     const bPrice = Number(b.querySelector("p").textContent.toLowerCase().split('€')[0]);
//     if (aPrice > bPrice) return 1;
//     if (aPrice < bPrice) return -1;
//     return 0;
// }

// const sortByPriceDesc = (a, b) => {
//     const aPrice = Number(a.querySelector("p").textContent.toLowerCase().split('€')[0]);
//     const bPrice = Number(b.querySelector("p").textContent.toLowerCase().split('€')[0]);
//     if (aPrice < bPrice) return 1;
//     if (aPrice > bPrice) return -1;
//     return 0;
// }


function sortByPrice(order = 'asc') {

    return function innerSort(a, b) {

        const aPrice = Number(a.querySelector("p").textContent.toLowerCase().split('€')[0]);
        const bPrice = Number(b.querySelector("p").textContent.toLowerCase().split('€')[0]);
        if (aPrice > bPrice) return (order === 'asc') ? 1 : -1;
        if (aPrice < bPrice) return (order === 'asc') ? -1 : 1;
        return 0;

    };

}



sort.addEventListener('change', function () {
    const method = Number(sort.value);

    switch (method) {

        case 0:
            items.sort(sortByNameAsc);
            break;
        case 1:
            items.sort(sortByNameDesc);
            break;
        case 2:
            // items.sort(sortByPriceAsc);
            items.sort(sortByPrice('asc'));
            break;
        case 3:
            // items.sort(sortByPriceDesc);
            items.sort(sortByPrice('desc'));
            break;

    }

    for (var i = 0; i < items.length; i++) {
        items[i].parentNode.appendChild(items[i]);
    }

}, false);

// Sort our items array by name ascending
items.sort(sortByNameAsc);
// Add each item from the sorted array to our div .items
for (var i = 0; i < items.length; i++) {
    // Get div .items and add our div .item to it
    items[i].parentNode.appendChild(items[i]);
}




