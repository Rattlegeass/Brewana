<template>
    <div class="container-fluid border-bottom border-dark-subtle position-relative" id="tentang-kami">
        <div class="overlay"></div>
        <div class="d-flex flex-row justify-content-center align-items-center" style="min-height: 275px; position: relative; z-index: 1;">
            <h1 class="display-4 fw-bold text-white">TENTANG KAMI</h1>
        </div>
    </div>

    <div class="container-fluid border-bottom border-dark-subtle p-4" style="min-height: 320px;">
        <div class="row g-2 m-15">
            <div class="col-12 col-lg-4">
                <div class="row g-2">
                    <div class="col-6">
                        <div class="overflow-hidden rounded shadow-sm" style="height: 175px;">
                            <img src="../assets/about-image/image11.jpg" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="overflow-hidden rounded shadow-sm" style="height: 175px;">
                            <img src="../assets/about-image/image7.jpg" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="overflow-hidden rounded shadow-sm" style="height: 175px;">
                            <img src="../assets/about-image/image12.jpg" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-2">
                <div class="row g-2">
                    <div class="col-12">
                        <div class="overflow-hidden rounded shadow-sm" style="height: 356px;">
                            <img src="../assets/about-image/image13.jpg" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="p-5 h-100 d-flex flex-column justify-content-center mx-4">
                    <h2 class="display-6 fw-bold mb-3">Produk Kami</h2>
                    <h4>Kami menyediakan biji kopi lokal dan impor berkualitas tinggi, serta alat pembuat kopi premium untuk pengalaman kopi yang sempurna.</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid border-bottom border-dark-subtle d-flex flex-column justify-content-center p-10" style="min-height: 300px;">
        <div class="row justify-content-center text-center">
            <div class="col-12 mx-auto overflow-hidden rounded-4 p-0" style="width: 90%; height: 450px">
                <img src="../assets/about-image/image19.jpg" alt="gambar2" class="img-fluid w-100 h-auto">
            </div>
            <div class="col-12 col-md-10 col-lg-8 my-10">
                <h2 class="display-6 fw-bold mb-3">Filosofi Kami</h2>
                <h4>
                    Di BREWANA, kopi bukan hanya minuman, melainkan sebuah perasaan. Kami mengutamakan kepuasan pelanggan kami, 
                    dengan menjual produk lokal dan impor yang berkualitas. Kami percaya bahwa setiap biji mengandung cerita rasa 
                    yang unik. Mari temukan cita rasa yang sempurna bersama kami.
                </h4>
            </div>
        </div>
    </div>

    <div class="container-fluid border-bottom border-dark-subtle p-4" style="min-height: 320px;">
        <div class="row g-2 m-15">
            <div class="col-12 col-lg-6">
                <div class="p-5 h-100 d-flex flex-column justify-content-center text-end mx-4">
                    <h2 class="display-6 fw-bold mb-3">Misi Kami</h2>
                    <h4>Menyatukan pecinta kopi dengan cita rasa terbaik, mendukung petani lokal, dan memperkenalkan tradisi kopi dari berbagai belahan dunia.</h4>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="overflow-hidden rounded shadow-sm">
                    <img src="../assets/about-image/image18.jpg" alt="Gambar Vertikal" class="w-100 h-100" style="object-fit: cover;">
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid p-20">
        <div class="text-center mb-6">
            <h2 class="display-6 fw-bold mb-3">Kunjungi Kami</h2>
            <h4>Ikuti kami di media sosial untuk pembaruan terbaru dan inspirasi kopi!</h4>
        </div>
        <div class="d-flex justify-content-center gap-3">
            <a href="https://instagram.com" class="text-decoration-none d-flex align-items-center justify-content-center rounded-circle border border-dark-subtle btn btn-active-light-info" style="width: 60px; height: 60px;">
                <i class="la la-instagram text-dark ms-1" style="font-size: 28px;"></i>
            </a>
            <a href="https://facebook.com" class="text-decoration-none d-flex align-items-center justify-content-center rounded-circle border border-dark-subtle btn btn-active-light-primary" style="width: 60px; height: 60px;">
                <i class="la la-facebook text-dark ms-1" style="font-size: 28px;"></i>
            </a>
            <a href="https://twitter.com" class="text-decoration-none d-flex align-items-center justify-content-center rounded-circle border border-dark-subtle btn btn-active-light-dark" style="width: 60px; height: 60px;">
                <i class="la la-twitter text-dark ms-1" style="font-size: 28px;"></i>
            </a>
        </div>
    </div>
</template>

<style scoped>
#tentang-kami {
    background-image: url("../assets/about-image/image1.jpg"); /* Ganti dengan path gambar yang sesuai */
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    position: relative;
}

#tentang-kami .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Efek gelap */
}
</style>
