// Storing DOM elements
const sort = document.querySelector("select");
let items = Array.from(document.querySelectorAll(".item"));

// Sorting functions
// Name ascending
const sortByNameAsc = (a, b) => a.querySelector("h2").textContent.toLowerCase().localeCompare(b.querySelector("h2").textContent.toLowerCase());

// Name descending
const sortByNameDesc = (a, b) => b.querySelector("h2").textContent.toLowerCase().localeCompare(a.querySelector("h2").textContent.toLowerCase());

// Price
const sortByPrice = (order = 'asc') => {

    return function innerSort(a, b) {

        const aPrice = Number(a.querySelector("p").textContent.toLowerCase().split('€')[0]);
        const bPrice = Number(b.querySelector("p").textContent.toLowerCase().split('€')[0]);
        if (aPrice > bPrice) return (order === 'asc') ? 1 : -1;
        if (aPrice < bPrice) return (order === 'asc') ? -1 : 1;
        return 0;

    };

}

// User feedback display
const displayUserFeedback = (closingDelay = 3000) => {

    // Check if one exists already
    // If so interrupt to not stack them
    if (document.querySelector(".feedback")) {
        return;
    }

    // If not existing create a div with feedback class
    const feedback = document.createElement("div");
    feedback.classList.add("feedback");
    // Add text to the div and add the whole element to the document body
    feedback.innerHTML += '<i class="fa-solid fa-check"></i> Copié avec succès !';
    document.body.appendChild(feedback);

    // Slide in animation
    gsap.to(".feedback", { bottom: '24px' });

    // Slide out animation then remove the element from the DOM
    setTimeout(() => {
        gsap.to(".feedback", { bottom: '-60px', onComplete: () => feedback.remove() });
    }, closingDelay);

}


// Detect changes made on the select input
sort.addEventListener('change', function () {
    // Retrieve the current selected value
    const method = Number(sort.value);

    // Depending on the value execute a specific sort
    switch (method) {

        case 0:
            items.sort(sortByNameAsc);
            break;
        case 1:
            items.sort(sortByNameDesc);
            break;
        case 2:
            items.sort(sortByPrice('asc'));
            break;
        case 3:
            items.sort(sortByPrice('desc'));
            break;

    }

    // When sorting is done, display the items in the specified order
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



// Copy to clipboard
items.forEach(item => {
    const itemName = item.querySelector("h2").textContent;
    item.querySelector("h2").addEventListener("click", () => {
        navigator.clipboard.writeText(itemName);
        displayUserFeedback();
    });
})



