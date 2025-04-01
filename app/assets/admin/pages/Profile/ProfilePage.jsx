import Breadcrumb from "@/admin/components/Navigation/Breadcrumb";
import PageHeader from "@/admin/components/Layout/PageHeader";
import Card from "@/admin/components/Card";
import ProfilePagePersonal from "@/admin/pages/Profile/Partials/ProfilePagePersonal";
import ProfilePageNavigation from "@/admin/pages/Profile/ProfilePageNavigation";
import {useState} from "react";
import ProfilePageSecurity from "@/admin/pages/Profile/Partials/ProfilePageSecurity";


const ProfilePage = () => {
    const [activeTab, setActiveTab] = useState("Personal");
    const tabs = [
        {
            name: "Personal",
            element: <ProfilePagePersonal/>
        },
        {
            name: "Security",
            element :<ProfilePageSecurity />
        }
    ];

    return (
      <>
          <PageHeader title={'Settings'}>
              <Breadcrumb />
          </PageHeader>

          <Card additionalClasses="mt-5 flex gap-6">
              <div className="w-[290px] h-full">
                  <ProfilePageNavigation activeTab={activeTab} setActiveTab={setActiveTab} tabs={tabs}/>
              </div>
              <div className="w-full">
                  {tabs.find(tab => tab.name === activeTab)?.element}
              </div>

          </Card>
      </>
    );
}

export default ProfilePage;
