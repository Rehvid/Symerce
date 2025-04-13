import AppFormFixedButton from '@/admin/components/form/AppFormFixedButton';
import React from 'react';

const FormLayout = ({mainColumn, sideColumn}) => {
  return (
    <div className="flex flex-row gap-[3rem] mt-5">
      <div className="flex flex-col w-full gap-[3rem]">
        {mainColumn}
      </div>

      {sideColumn}

      <AppFormFixedButton />
    </div>
  );
}

export default FormLayout;
