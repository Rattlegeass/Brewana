import type { MenuItem } from "@/layouts/default-layout/config/types";

const MainMenuConfig: Array<MenuItem> = [
    {
        pages: [
            {
                heading: "Dashboard",
                name: "dashboard",
                route: "/dashboard",
                keenthemesIcon: "element-11",
            },
        ],
    },
    
    {
        heading: "Website",
        route: "/dashboard/website",
        name: "website",
        pages: [
            {
                heading: "Pembayaran",
                name: "pembayaran",
                route: "/dashboard/pembayaran",
                keenthemesIcon: "credit-cart",
            },
            {
                heading: "Pengiriman",
                name: "pengiriman",
                route: "/dashboard/pengiriman",
                keenthemesIcon: "delivery",
            },
            {
                sectionTitle: "Master",
                route: "/master",
                keenthemesIcon: "cube-3",
                name: "master",
                sub: [
                    {
                        sectionTitle: "Barang",
                        route: "/barang",
                        name: "master-barang",
                        sub: [
                            {
                                heading: "Promo",
                                name: "master-promo",
                                route: "/dashboard/master/barang/promo",
                            },
                            {
                                heading: "Kategori",
                                name: "master-kategori",
                                route: "/dashboard/master/barang/kategori",
                            },
                            {
                                heading: "Barang",
                                name: "master-barang",
                                route: "/dashboard/master/barang",
                            },
                        ],
                    },
                    {
                        sectionTitle: "User",
                        route: "/users",
                        name: "master-user",
                        sub: [
                            {
                                heading: "Role",
                                name: "master-role",
                                route: "/dashboard/master/users/roles",
                            },
                            {
                                heading: "User",
                                name: "master-user",
                                route: "/dashboard/master/users",
                            },
                        ],
                    },
                ],
            },
            {
                heading: "Setting",
                route: "/dashboard/setting",
                name: "setting",
                keenthemesIcon: "setting-2",
            },
        ],
    },
];

export default MainMenuConfig;
