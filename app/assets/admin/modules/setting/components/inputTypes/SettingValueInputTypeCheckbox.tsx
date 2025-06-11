import Switch from '@admin/common/components/form/input/Switch';
import { Path, UseFormRegister } from 'react-hook-form';
import { SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import { FC } from 'react';

interface SettingValueInputTypeCheckboxProps {
    register: UseFormRegister<SettingFormData>;
}

const SettingValueInputTypeCheckbox: FC<SettingValueInputTypeCheckboxProps> = ({register}) => (
    <Switch {...register('value' as Path<SettingFormData>)} />
  )

export default SettingValueInputTypeCheckbox;
