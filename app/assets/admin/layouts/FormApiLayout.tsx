import PageHeader from '@admin/layouts/components/PageHeader';
import FormFooterActions from '@admin/common/components/form/FormFooterActions';
import React from 'react';

interface FormApiLayout {
  pageTitle?: string,
  children: React.ReactNode,
}

const FormApiLayout: React.FC<FormApiLayout> = ({ pageTitle, children }) => (
  <>
    {pageTitle && <PageHeader title={pageTitle} />}

    <div className="flex flex-col gap-[1rem] mt-5 pb-[100px]">
      {children}
      <FormFooterActions />
    </div>
  </>
)



export default FormApiLayout;
