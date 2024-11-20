const API_URL = "http://localhost/PrakMod4/api/products";

// Memuat produk dari API
async function loadProducts() {
  try {
    const response = await fetch(`${API_URL}/read.php`);
    if (!response.ok) throw new Error("Network response was not ok");
    const products = await response.json();

    if (products.length === 0) {
      throw new Error("No products found.");
    }

    // Pastikan produk ditampilkan di section "Our Products"
    const productGrid = document.querySelector(".products .product-grid");
    productGrid.innerHTML = products
      .map(
        (product) => `
          <div class="product-item" data-id="${product.id}">
            <img src="${product.image}" alt="${product.name}" />
            <h3>${product.name}</h3>
            <p class="price">Rp ${parseFloat(product.price).toLocaleString(
              "id-ID"
            )}</p>
            <p>${product.description || "No description available"}</p>
          </div>
        `
      )
      .join("");

    // Memuat produk di bagian Featured Products
    const featuredProductGrid = document.getElementById("featuredProducts");
    const featuredProducts = products.slice(0, 2); // Menampilkan 2 produk pertama sebagai featured
    featuredProductGrid.innerHTML = featuredProducts
      .map(
        (product) => `
        <div class="product-item" data-id="${product.id}">
          <img src="${product.image}" alt="${product.name}" />
          <h3>${product.name}</h3>
          <p class="price">Rp. ${parseFloat(product.price).toLocaleString()}</p>
        </div>
      `
      )
      .join("");
  } catch (error) {
    console.error("Error loading products:", error);
    const productGrid = document.querySelector(".product-grid");
    const featuredProductGrid = document.getElementById("featuredProducts");

    // Menampilkan pesan error jika produk gagal dimuat
    productGrid.innerHTML =
      "<p>Failed to load products. Please try again later.</p>";
    featuredProductGrid.innerHTML =
      "<p>No featured products available at the moment.</p>";
  }
}

// Memanggil loadProducts saat halaman dimuat
loadProducts();

// Fungsi untuk smooth scroll ke bagian produk
function scrollToProducts() {
  document.getElementById("products").scrollIntoView({ behavior: "smooth" });
}

// Fungsi untuk melihat detail produk (stub untuk integrasi dengan database)
function viewDetails(productId) {
  alert(
    `Product ID: ${productId}. Connect this to a database for dynamic details.`
  );
}

// Menangani pengiriman formulir kontak
function sendMessage(event) {
  event.preventDefault();
  const name = document.getElementById("name").value;
  const email = document.getElementById("email").value;
  const message = document.getElementById("message").value;

  // Menampilkan konfirmasi pengiriman pesan
  alert(`Thank you, ${name}. Your message has been sent.`);
  // Reset formulir setelah pengiriman
  document.getElementById("contactForm").reset();
}

// Fungsi untuk mencari produk berdasarkan nama
function searchProducts() {
  const query = document.getElementById("searchBar").value.toLowerCase();
  const products = document.querySelectorAll(".product-item");

  products.forEach((product) => {
    const productName = product.querySelector("h3").textContent.toLowerCase();
    product.style.display = productName.includes(query) ? "block" : "none";
  });
}

// Fungsi untuk berlangganan newsletter
function subscribeNewsletter(event) {
  event.preventDefault();
  const email = document.getElementById("newsletterEmail").value;

  alert(`Thank you for subscribing! We've added ${email} to our mailing list.`);
  document.getElementById("newsletterForm").reset();
}
