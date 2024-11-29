import { Head, Link } from "@inertiajs/react";

const Welcome = ({ auth }) => {
    //const { user } = useAuth();
    const now = new Date();
    const currentHour = now.getHours();
    const isDarkMode = currentHour < 6 || currentHour >= 18;

    if (
        isDarkMode &&
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    ) {
        document.documentElement.classList.add("dark");
    }

    return (
        <>
            <Head>
                <link rel="icon" type="image/png" href="/ico.png" />
            </Head>
            <div className="flex flex-col antialiased font-montserrat h-max">
                <div className="flex-grow">
                    <nav className="fixed top-0 z-20 w-full bg-white border-b border-gray-200 dark:bg-gray-900 start-0 dark:border-gray-600">
                        <div className="flex flex-wrap items-center justify-between max-w-screen-xl p-4 mx-auto">
                            <Link
                                to="/"
                                className="flex items-center space-x-3 rtl:space-x-reverse"
                            >
                                <img
                                    src="/logo.png"
                                    className="h-14"
                                    alt="Flowbite Logo"
                                />
                            </Link>
                            <div className="flex md:order-2">
                                {auth.user ? (
                                    <>
                                        <LivewireComponent name="public.pedido.cart" />
                                        <LivewireComponent name="menu-user" />
                                    </>
                                ) : (
                                    <>
                                        <Link
                                            href={route("login")}
                                            className="hidden px-3 py-2 ml-4 text-black bg-black rounded md:block md:bg-transparent md:p-0 hover:underline dark:text-white"
                                        >
                                            Ingresar
                                        </Link>
                                        <Link
                                            href={route("register")}
                                            className="hidden px-3 py-2 ml-4 text-black bg-black rounded md:block md:bg-transparent md:p-0 hover:underline dark:text-white"
                                        >
                                            Registrarse
                                        </Link>
                                    </>
                                )}
                                <button
                                    data-collapse-toggle="navbar-search"
                                    type="button"
                                    className="inline-flex items-center justify-center w-10 h-10 p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                                >
                                    <span className="sr-only">
                                        Open main menu
                                    </span>
                                    <svg
                                        className="w-5 h-5"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 17 14"
                                    >
                                        <path
                                            stroke="currentColor"
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                            strokeWidth="2"
                                            d="M1 1h15M1 7h15M1 13h15"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <div
                                className="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                                id="navbar-search"
                            >
                                <ul className="flex flex-col p-4 mt-4 font-medium border border-gray-100 rounded-lg md:p-0 bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                                    {auth.user ? null : (
                                        <>
                                            <li>
                                                <Link
                                                    href={route("login")}
                                                    className="block px-3 py-2 text-gray-900 rounded md:hidden hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                                >
                                                    Ingresar
                                                </Link>
                                            </li>
                                            <li>
                                                <Link
                                                    href={route("register")}
                                                    className="block px-3 py-2 text-gray-900 rounded md:hidden hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                                >
                                                    Registrarse
                                                </Link>
                                            </li>
                                        </>
                                    )}
                                    <li>
                                        <Link
                                            to="/"
                                            className="block px-3 py-2 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                        >
                                            Inicio
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            to="/productos"
                                            className="block px-3 py-2 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                        >
                                            Productos
                                        </Link>
                                    </li>
                                    <li>
                                        <Link
                                            to="/contacto"
                                            className="block px-3 py-2 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700"
                                        >
                                            Contacto
                                        </Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                    <br />
                    <br />
                    <br />
                    {/* {fondo && ( */}
                    <div className="relative w-full">
                        <div className="absolute inset-0">
                            <img
                                className="object-cover w-full h-full"
                                src="/inicio.jpg"
                                alt="People working on laptops"
                            />
                            <div
                                className="absolute inset-0 bg-gray-500 mix-blend-multiply"
                                aria-hidden="true"
                            ></div>
                        </div>
                        <div className="relative px-4 py-24 mx-auto max-w-7xl sm:py-32 sm:px-6 lg:px-8">
                            <h1 className="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
                                Productos{" "}
                                <span className="block xl:inline">
                                    de la mejor calidad
                                </span>
                            </h1>
                            <p className="mt-6 text-xl text-gray-300 dark:text-white">
                                Tenemos los mejores productos para ti, de la
                                mejor calidad y al mejor precio.
                            </p>
                        </div>
                    </div>
                {/* )} */}
                    <div className="max-w-screen-xl mx-auto mt-2">
                        <div className="p-4">
                            {/* Aquí iría el contenido dinámico */}
                        </div>
                    </div>
                </div>
                <div>
                    <div className="max-w-screen-xl mx-auto">
                        <div className="p-4">
                            Visitas: {/* Aquí irían las visitas dinámicas */}
                        </div>
                    </div>
                    <footer className="w-full bg-white rounded-lg shadow dark:bg-gray-800">
                        <div className="w-full max-w-screen-xl p-4 mx-auto md:flex md:items-center md:justify-between">
                            <span className="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                                © 2024{" "}
                                <Link to="/" className="hover:underline">
                                    Laura
                                </Link>
                                . All Rights Reserved.
                            </span>
                            <ul className="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
                                <li>
                                    <Link
                                        to="#"
                                        className="hover:underline me-4 md:me-6"
                                    >
                                        Acerca
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        to="#"
                                        className="hover:underline me-4 md:me-6"
                                    >
                                        Políticas de privacidad
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        to="#"
                                        className="hover:underline me-4 md:me-6"
                                    >
                                        Licencia
                                    </Link>
                                </li>
                                <li>
                                    <Link to="#" className="hover:underline">
                                        Contacto
                                    </Link>
                                </li>
                            </ul>
                        </div>
                    </footer>
                </div>
                {/* <LivewireStyles />
            <LivewireScripts /> */}
            </div>
        </>
    );
};

export default Welcome;
