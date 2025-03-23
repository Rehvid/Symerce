import NavigationItem from '../Navigation/NavigationItem';

function SideBar() {
    return (
        <aside className="fixed mt-16 flex flex-col lg:mt-0 top-0 px-5 left-0 bg-white text-gray-900 h-screen transition-all duration-300 ease-in-out z-50 border-r border-gray-200 w-[290px] -translate-x-full lg:translate-x-0">
            <div className="py-8 flex justify-start">
                <a>
                    <img src="logo.svg" />
                </a>
            </div>
            <div className="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
                <ul className="flex flex-col gap-4">
                    <NavigationItem to={'dashboard'}>Dashboard</NavigationItem>
                    <NavigationItem to={'categories'}>Categories</NavigationItem>
                    <NavigationItem to={'products'}>Products</NavigationItem>
                </ul>
            </div>
        </aside>
    );
}

export default SideBar;
