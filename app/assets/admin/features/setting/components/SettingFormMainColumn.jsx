import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import Select from '@/shared/components/Select';

const SettingFormMainColumn = ({ isProtected, register, fieldErrors, formData, setValue }) => {

  const settingValue = formData?.settingValue;
  let selected = '';
  if (settingValue && settingValue?.type === 'select') {
    const selectedParse = JSON.parse(formData.value);
    selected = settingValue?.value.find(element => element.value === Number(selectedParse.id));
  }

    const onChange = (e) => {
        setValue('type', e.target.value);
    };

    const onSettingValueChange = (e) => {
      let value = null;
      const findValue = settingValue?.value.find(element => element.value === Number(e.target.value));
      if (findValue) {
         value = {
           id: findValue.value,
           name: findValue.label
         };
      }
      setValue('value', value);
    }

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
                    />

                    {formData.types && (
                        <div>
                            Typy
                            <Select onChange={onChange} selected={formData.type} options={formData.types} />
                        </div>
                    )}
                </>
            )}
          {settingValue && settingValue?.type === 'select' ? (
            <Select onChange={onSettingValueChange} selected={selected} options={settingValue?.value} />
          ) : (
            <Input
              {...register('value', {
                ...validationRules.required(),
                ...validationRules.minLength(3),
              })}
              type="text"
              id="value"
              label="Wartość"
              hasError={!!fieldErrors?.value}
              errorMessage={fieldErrors?.value?.message}
              isRequired
            />
          )}

        </>
    );
};

export default SettingFormMainColumn;
