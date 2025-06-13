import { validationRules } from '@admin/common/utils/validationRules';
import ControlledReactSelect from '@admin/common/components/form/reactSelect/ControlledReactSelect';
import { SettingField, SettingFormData } from '@admin/modules/setting/interfaces/SettingFormData';
import { Control, Path } from 'react-hook-form';
import { FC } from 'react';

interface SettingValueInputTypeProps {
    control: Control<SettingFormData>;
    settingField: SettingField;
    isMulti: boolean;
}

const SettingValueInputTypeSelect: FC<SettingValueInputTypeProps> = ({ control, settingField, isMulti }) => (
    <ControlledReactSelect
        name={'value' as Path<SettingFormData>}
        control={control}
        options={settingField.availableOptions}
        rules={{
            ...validationRules.required(),
        }}
        isMulti={isMulti}
    />
);

export default SettingValueInputTypeSelect;
