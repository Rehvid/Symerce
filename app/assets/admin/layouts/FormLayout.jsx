import FormFooterActions from '@/admin/components/form/FormFooterActions';
import Breadcrumb from '@/admin/layouts/components/breadcrumb/Breadcrumb';
import PageHeader from '@/admin/layouts/components/PageHeader';

const FormLayout = ({ mainColumn, sideColumn, pageTitle }) => {
    return (
        <>
            {pageTitle && (
                <PageHeader title={pageTitle}>
                    <Breadcrumb />
                </PageHeader>
            )}

            <div className="flex flex-row gap-[3rem] mt-5 pb-[100px]">
                <div className="flex flex-col w-full gap-[3.25rem]">{mainColumn}</div>

                {sideColumn}

                <FormFooterActions />
            </div>
        </>
    );
};

export default FormLayout;
