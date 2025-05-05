import FormFooterActions from '@/admin/components/form/FormFooterActions';
import PageHeader from '@/admin/layouts/components/PageHeader';
import Card from '@/admin/components/Card';

const FormLayout = ({ mainColumn, sideColumn, pageTitle }) => {
    return (
        <>
            {pageTitle && <PageHeader title={pageTitle} />}

            <div className="flex xl:flex-row flex-col gap-[3rem] mt-5 pb-[100px]">
                <Card additionalClasses="flex flex-col w-full gap-[2rem] h-full">{mainColumn}</Card>

                {sideColumn && sideColumn}

                <FormFooterActions />
            </div>
        </>
    );
};

export default FormLayout;
