import { Path, UseFormRegister } from 'react-hook-form';
import { SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import { FC } from 'react';

interface SettingValueInputTypeRawTextareaProps {
    register: UseFormRegister<SettingFormData>;
}

const SettingValueInputTypeRawTextarea: FC<SettingValueInputTypeRawTextareaProps> = ({register}) => (
    <textarea
        {...register('value' as Path<SettingFormData>)}
        className="w-full rounded-lg border border-gray-300 p-2 transition-all focus:ring-4 focus:border-primary focus:border-1 focus:outline-hidden focus:ring-primary-light"
    />
  )


export default SettingValueInputTypeRawTextarea;
