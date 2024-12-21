import {
    createRouter,
    createWebHistory,
    type RouteRecordRaw,
} from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { useConfigStore } from "@/stores/config";
import NProgress from "nprogress";
import "nprogress/nprogress.css";

declare module "vue-router" {
    interface RouteMeta {
        pageTitle?: string;
        permission?: string;
    }
}

const routes: Array<RouteRecordRaw> = [
    {
        path: "/",
        redirect: "/landing/home",
        component: () => import("@/layouts/default-layout/DefaultLayout.vue"),
        meta: {
            middleware: "auth",
        },
        children: [
            {
                path: "/dashboard",
                name: "dashboard",
                component: () => import("@/pages/dashboard/Index.vue"),
                meta: {
                    pageTitle: "Dashboard",
                    breadcrumbs: ["Dashboard"],
                    permission: "dashboard",
                },
            },
            // {
            //     path: "/dashboard/profile",
            //     name: "dashboard.profile",
            //     component: () => import("@/pages/dashboard/profile/Index.vue"),
            //     meta: {
            //         pageTitle: "Profile",
            //         breadcrumbs: ["Profile"],
            //     },
            // },
            {
                path: "/dashboard/setting",
                name: "dashboard.setting",
                component: () => import("@/pages/dashboard/setting/Index.vue"),
                meta: {
                    pageTitle: "Website Setting",
                    breadcrumbs: ["Website", "Setting"],
                    permission: "setting",
                },
            },

            // MASTER
            {
                path: "/dashboard/master/barang",
                name: "dashboard.master.barang",
                component: () => 
                    import("@/pages/dashboard/master/barangs/Index.vue"),
                meta: {
                    pageTitle: "Barang",
                    breadcrumbs: ["Master", "Barang"],
                    permission: "master-barang",
                }
            },
            {
                path: "/dashboard/master/barang/kategori",
                name: "dashboard.master.barang.kategori",
                component: () => 
                    import("@/pages/dashboard/master/barangs/kategori/Index.vue"),
                meta: {
                    pageTitle: "Kategori Barang",
                    breadcrumbs: ["Master", "Barang", "Kategori"],
                    permission: "master-kategori",
                }
            },
            {
                path: "/dashboard/master/promo",
                name: "dashboard.master.promo",
                component: () => 
                    import("@/pages/dashboard/master/promos/Index.vue"),
                meta: {
                    pageTitle: "Promo",
                    breadcrumbs: ["Master", "Promo"],
                    permission: "master-promo",
                }
            },
            {
                path: "/dashboard/master/promo/diskon",
                name: "dashboard.master.promo.diskon",
                component: () => 
                    import("@/pages/dashboard/master/promos/diskon/Index.vue"),
                meta: {
                    pageTitle: "Diskon",
                    breadcrumbs: ["Master", "Barang", "Diskon"],
                    permission: "master-diskon",
                }
            },
            {
                path: "/dashboard/master/users/roles",
                name: "dashboard.master.users.roles",
                component: () =>
                    import("@/pages/dashboard/master/users/roles/Index.vue"),
                meta: {
                    pageTitle: "User Roles",
                    breadcrumbs: ["Master", "Users", "Roles"],
                    permission: "master-role",
                },
            },
            {
                path: "/dashboard/master/users",
                name: "dashboard.master.users",
                component: () =>
                    import("@/pages/dashboard/master/users/Index.vue"),
                meta: {
                    pageTitle: "Users",
                    breadcrumbs: ["Master", "Users"],
                    permission: "master-user",
                },
            },
        ],
    },
    {
        path: "/",
        component: () => import("@/layouts/AuthLayout.vue"),
        children: [
            {
                path: "/sign-in",
                name: "sign-in",
                component: () => import("@/pages/auth/sign-in/Index.vue"),
                meta: {
                    pageTitle: "Sign In",
                    middleware: "guest",
                },
            },
            {
                path: "/sign-up",
                name: "sign-up",
                component: () => import("@/pages/auth/sign-up/Index.vue"),
                meta: {
                    pageTitle: "Sign Up",
                    middleware: "guest",
                },
            },
            {
                path: "/verify-otp/:email",
                name: "verify-otp",
                component: () => import("@/pages/auth/sign-up/steps/VerifyOtp.vue"),
                meta: {
                    pageTitle: "Verify Otp",
                    middleware: "guest",
                },
            },
        ],
    },
    {
        path: "/",
        component: () => import("@/layouts/SystemLayout.vue"),
        children: [
            {
                // the 404 route, when none of the above matches
                path: "/404",
                name: "404",
                component: () => import("@/pages/errors/Error404.vue"),
                meta: {
                    pageTitle: "Error 404",
                },
            },
            {
                path: "/500",
                name: "500",
                component: () => import("@/pages/errors/Error500.vue"),
                meta: {
                    pageTitle: "Error 500",
                },
            },
        ],
    },
    {
        path: "/:pathMatch(.*)*",
        redirect: "/404",
    },

    // Landing Page
    {
        path: "/landing",
        name: "landing",
        redirect: "/landing/home",
        component: () => import("@/layouts/landing-layout/LandingLayout.vue"),
        children: [
            {
                path: "/landing/home",
                name: "landing.home",
                component: () => import("@/pages/landing/home/Index.vue"),
            },
            {
                path: "/landing/toko",
                name: "landing.toko",
                component: () => import("@/pages/landing/toko/Index.vue"),
            },
            {
                path: "/landing/tentang-kami",
                name: "landing.tentang-kami",
                component: () => import("@/pages/landing/tentang-kami/Index.vue"),
            },
            {
                path: "/landing/keranjang",
                name: "landing.keranjang",
                component: () => import("@/pages/landing/keranjang/Index.vue"),
            },
            {
                path: "/landing/profil",
                name: "landing.profil",
                component: () => import("@/pages/landing/profil/Index.vue"),
            },
        ]
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes,
    scrollBehavior(to) {
        // If the route has a hash, scroll to the section with the specified ID; otherwise, scroll to the top of the page.
        if (to.hash) {
            return {
                el: to.hash,
                top: 80,
                behavior: "smooth",
            };
        } else {
            return {
                top: 0,
                left: 0,
                behavior: "smooth",
            };
        }
    },
});

router.beforeEach(async (to, from, next) => {
    if (to.name) {
        // Start the route progress bar.
        NProgress.start();
    }

    const authStore = useAuthStore();
    const configStore = useConfigStore();

    // current page view title
    if (to.meta.pageTitle) {
        document.title = `${to.meta.pageTitle} - ${import.meta.env.VITE_APP_NAME}`;
    } else {
        document.title = import.meta.env.VITE_APP_NAME as string;
    }

    // reset config to initial state
    configStore.resetLayoutConfig();

    // verify auth token before each page change
    if (!authStore.isAuthenticated) await authStore.verifyAuth();

    // before page access check if page requires authentication
    if (to.meta.middleware == "auth") {
        if (authStore.isAuthenticated) {
            if (to.meta.permission && !authStore.user.permission.includes(to.meta.permission)) {
                next({ name: "404" });
            } else if (to.path == '/') {
                if (authStore.user?.role?.name == "admin") {
                    next({ name: "dashboard" });
                } else {
                    next({ name: "landing" });
                }
            } else if (to.meta.checkDetail == false) {
                next();
            }

            next();
        } else {
            next({ name: "sign-in" });
        }
    } else if (to.meta.middleware == "guest" && authStore.isAuthenticated) {
        if (authStore.user?.role?.name == "admin") {
            next({ name: "dashboard" });
        } else {
            next({ name: "landing" });
        }
    } else {
        next();
    }
});

router.afterEach(() => {
    // Complete the animation of the route progress bar.
    NProgress.done();
});

export default router;
