document
  .getElementById("registrationForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const name = document.getElementById("name").value;
    const email = document.getElementById("email").value;
    const address = document.getElementById("address").value;

    if (name === "" || email === "" || address === "") {
      alert("Semua field harus diisi!");
    } else {
      alert("Pendaftaran berhasil!");
    }
  });
