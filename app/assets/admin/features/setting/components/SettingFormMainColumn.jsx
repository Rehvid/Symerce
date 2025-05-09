import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import Select from '@/admin/components/form/controls/Select';
import { Controller } from 'react-hook-form';
import LabelNameIcon from '@/images/icons/label-name.svg';
import SettingValueTypeSelect from '@/admin/features/setting/components/types/SettingValueTypeSelect';
import SettingValueTypePlainText from '@/admin/features/setting/components/types/SettingValueTypePlainText';
import { isValidEnumValue } from '@/admin/utils/helper';
import { SETTING_VALUE_TYPES } from '@/admin/constants/settingValueConstants';
import SettingValueTypeMultiSelect from '@/admin/features/setting/components/types/SettingValueTypeMultiSelect';
import Switch from '@/admin/components/form/controls/Switch';

const SettingFormMainColumn = ({ isProtected, register, fieldErrors, formData, control }) => {
    const settingValue = formData?.settingValue;

    const renderSettingValueType = () => {
        const settingType = settingValue?.type || null;
        if (!settingType || !isValidEnumValue(SETTING_VALUE_TYPES, settingType)) {
            return null;
        }

        switch (settingType) {
            case SETTING_VALUE_TYPES.PLAIN_TEXT:
                return <SettingValueTypePlainText register={register} fieldErrors={fieldErrors} />;

            case SETTING_VALUE_TYPES.SELECT:
                return <SettingValueTypeSelect formData={formData} settingValue={settingValue} control={control} />;

            case SETTING_VALUE_TYPES.MULTI_SELECT:
                return (
                    <SettingValueTypeMultiSelect
                        formData={formData}
                        settingValue={settingValue}
                        control={control}
                        fieldErrors={fieldErrors}
                    />
                );
            default:
                return null;
        }
    };

    return (
        <>
            {!isProtected && (
                <>
                    <Input
                        {...register('name', {
                            ...validationRules.required(),
                            ...validationRules.minLength(3),
                        })}
                        type="text"
                        id="name"
                        label="Nazwa"
                        hasError={!!fieldErrors?.name}
                        errorMessage={fieldErrors?.name?.message}
                        isRequired
                        icon={<LabelNameIcon className="text-gray-500 w-[24px] h-[24px]" />}
                    />
                    {formData.types && (
                        <Controller
                            name="type"
                            control={control}
                            defaultValue={[]}
                            render={({ field }) => (
                                <Select
                                    label="Typy"
                                    options={formData.types || []}
                                    selected={field.value}
                                    onChange={(value) => {
                                        field.onChange(value);
                                    }}
                                />
                            )}
                        />
                    )}
                    <Switch label="Czy dane są w formacie JSON?" {...register('isJson')} />
                </>
            )}
            {settingValue && renderSettingValueType()}
        </>
    );
};

export default SettingFormMainColumn;
