import InputField from '@admin/common/components/form/input/InputField';
import React, { FC } from 'react';
import { SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import { Path, UseFormRegister } from 'react-hook-form';

interface SettingValueInputFieldTypeProps {
    register: UseFormRegister<SettingFormData>;
    type: string;
    icon?: React.ReactNode | null;
}

const SettingValueInputFieldType: FC<SettingValueInputFieldTypeProps> = ({ register, type, icon }) => (
    <InputField type={type} id="value" icon={icon && icon} {...register('value' as Path<SettingFormData>)} />
);

export default SettingValueInputFieldType;
