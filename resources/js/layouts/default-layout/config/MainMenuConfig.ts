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

    // WEBSITE
    {
        heading: "Website",
        route: "/dashboard/website",
        name: "website",
        pages: [
            // MASTER
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
                        sectionTitle: "Promo",
                        route: "/promo",
                        name: "master-promo",
                        sub: [
                            {
                                heading: "Diskon",
                                name: "master-diskon",
                                route: "/dashboard/master/promo/diskon",
                            },
                            {
                                heading: "Promo",
                                name: "master-promo",
                                route: "/dashboard/master/promo",
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
