import FormFooterActions from '@/admin/components/form/FormFooterActions';
import React from 'react';

const FormLayout = ({mainColumn, sideColumn}) => {
  return (
    <div className="flex flex-row gap-[3rem] mt-5">
      <div className="flex flex-col w-full gap-[3.25rem]">
        {mainColumn}
      </div>

      {sideColumn}

      <FormFooterActions />
    </div>
  );
}

export default FormLayout;
