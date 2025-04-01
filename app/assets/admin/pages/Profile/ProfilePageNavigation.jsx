import AppButton from "@/admin/components/Common/AppButton";

const ProfilePageNavigation = ({activeTab, setActiveTab, tabs}) => {
    const activeClasses = `bg-primary-light text-primary font-medium hover:bg-primary-light`;

    return (
        <>
            <ul className="flex flex-col gap-5">
                {tabs.map((tab, index) => {
                    return (
                        <AppButton
                            variant="sideBar"
                            additionalClasses={`py-2 px-5 ${tab.name === activeTab ? activeClasses : ''}`}
                            key={index}
                            onClick={() => setActiveTab(tab.name)}
                        >
                            {tab.name}
                        </AppButton>
                    )
                })}
            </ul>
        </>
    )
}

export default ProfilePageNavigation;
