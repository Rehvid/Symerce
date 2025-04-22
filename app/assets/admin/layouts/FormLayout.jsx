import FormFooterActions from '@/admin/components/form/FormFooterActions';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Card from '@/admin/components/Card';

const FormLayout = ({ mainColumn, sideColumn, pageTitle }) => {
    return (
        <>
            {pageTitle && (
                <PageHeader title={pageTitle}>
                    <Breadcrumb />
                </PageHeader>
            )}

            <div className="flex flex-row gap-[3rem] mt-5 pb-[100px]">
                <Card additionalClasses="flex flex-col w-full gap-[2rem] h-full">{mainColumn}</Card>

                {sideColumn}

                <FormFooterActions />
            </div>
        </>
    );
};

export default FormLayout;
