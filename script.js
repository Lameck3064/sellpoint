// JavaScript for Scroll Animations
document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".fade-up");
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    elements.forEach((el) => observer.observe(el));
});

// Smooth Scrolling for Nav Links
document.querySelectorAll(".nav-item").forEach((link) => {
    link.addEventListener("click", (e) => {
        const href = e.target.getAttribute("href");
        if (href.startsWith("#")) {
            e.preventDefault();
            const targetId = href.substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: "smooth",
                });
            }
        } else {
            // Allow navigation to other pages
            window.location.href = href;
        }
    });    
});


// Animate Subscription Cards on Scroll
document.addEventListener("DOMContentLoaded", () => {
    const cards = document.querySelectorAll(".plan-card");
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1 }
    );

    cards.forEach((card) => observer.observe(card));
});
//

// Sample Data
const users = [
    { username: "john_doe", email: "john@example.com" },
    { username: "jane_doe", email: "jane@example.com" },
];

const products = [
    { name: "Product 1", category: "Category A", price: "$10" },
    { name: "Product 2", category: "Category B", price: "$20" },
];

// Function to load Users Data
function loadUsers() {
    const userTable = document.getElementById('userTable').getElementsByTagName('tbody')[0];
    userTable.innerHTML = ""; // Clear the table before adding new rows

    users.forEach(user => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${user.username}</td>
            <td>${user.email}</td>
            <td>
                <a href="#">Edit</a> | <a href="#">Delete</a>
            </td>
        `;
        userTable.appendChild(row);
    });
}

// Function to load Products Data
function loadProducts() {
    const productTable = document.getElementById('productTable').getElementsByTagName('tbody')[0];
    productTable.innerHTML = ""; // Clear the table before adding new rows

    products.forEach(product => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product.name}</td>
            <td>${product.category}</td>
            <td>${product.price}</td>
            <td>
                <a href="#">Edit</a> | <a href="#">Delete</a>
            </td>
        `;
        productTable.appendChild(row);
    });
}

// Set Active Link in Sidebar
function setActiveLink(linkId) {
    const links = document.querySelectorAll('.admin-sidebar a');
    links.forEach(link => {
        link.classList.remove('active'); // Remove active class from all links
    });
    const activeLink = document.getElementById(linkId);
    if (activeLink) {
        activeLink.classList.add('active'); // Add active class to the clicked link
    }
}

// Handle Sidebar Links
document.getElementById('manageUsersLink').addEventListener('click', function() {
    setActiveLink('manageUsersLink');
    document.getElementById('pageTitle').textContent = 'Manage Users';
    document.getElementById('manageUsersSection').style.display = 'block'; // Show user section
    document.getElementById('manageProductsSection').style.display = 'none'; // Hide product section
    document.getElementById('subscriptionsSection').style.display = 'none'; // Hide subscription section
    loadUsers(); // Load user data
});

document.getElementById('manageProductsLink').addEventListener('click', function() {
    setActiveLink('manageProductsLink');
    document.getElementById('pageTitle').textContent = 'Manage Products';
    document.getElementById('manageUsersSection').style.display = 'none'; // Hide user section
    document.getElementById('manageProductsSection').style.display = 'block'; // Show product section
    document.getElementById('subscriptionsSection').style.display = 'none'; // Hide subscription section
    loadProducts(); // Load product data
});

document.getElementById('subscriptionsLink').addEventListener('click', function() {
    setActiveLink('subscriptionsLink');
    document.getElementById('pageTitle').textContent = 'Subscriptions';
    document.getElementById('manageUsersSection').style.display = 'none'; // Hide user section
    document.getElementById('manageProductsSection').style.display = 'none'; // Hide product section
    document.getElementById('subscriptionsSection').style.display = 'block'; // Show subscription section
    // Add functionality for Subscriptions if needed
});

// Initially load Users
loadUsers();
function subscribePlan(planAmount) {
    // Hide the subscription plans
    document.querySelector('.plans-container').classList.add('hidden');

    // Show the subscription form (phone number input and subscribe button)
    document.getElementById('subscription-form').style.display = 'block';

    // Optionally, you can store the plan amount to send with the payment
    window.selectedPlan = planAmount;
}

function initiatePayment() {
    const phoneNumber = document.getElementById('phoneNumber').value;

    if (/^\d{10}$/.test(phoneNumber)) {
        fetch('mpesa_payment.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `phone=254${phoneNumber.slice(1)}&amount=500` // Convert to Kenyan format
        })
        .then(response => response.json())
        .then(data => {
            if (data.ResponseCode === "0") {
                alert('Payment request sent. Check your phone.');
            } else {
                alert('Payment failed: ' + data.errorMessage);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Payment initiation failed. Try again.');
        });
    } else {
        alert('Please enter a valid 10-digit phone number.');
    }
}




