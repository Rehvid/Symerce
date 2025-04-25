import { validationRules } from '@/admin/utils/validationRules';
import Input from '@/admin/components/form/controls/Input';
import Select from '@/admin/components/form/controls/Select';
import { Controller } from 'react-hook-form';
import { useEffect, useState } from 'react';


const SettingFormMainColumn = ({ isProtected, register, fieldErrors, formData, control }) => {
    const [selectedOption, setSelectedOption] = useState('');

    useEffect(() => {
        if (settingValue && settingValue?.type === 'select') {
            const selectedParse = JSON.parse(formData.value);
            setSelectedOption(settingValue?.value.find((element) => element.value === Number(selectedParse.id)).value);
        }
    }, [formData?.settingValue]);

    const settingValue = formData?.settingValue;

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
                      <Controller
                        name="type"
                        control={control}
                        defaultValue={[]}
                        render={({ field }) => (
                          <div>
                              <Select
                                label="Typy"
                                options={formData.types || []}
                                selected={field.value}
                                onChange={(value) => {
                                    field.onChange(value);
                                }}
                              />
                          </div>
                          )}
                      />
                    )}
                </>
            )}
            {settingValue && settingValue?.type === 'select' ? (
                <Controller
                  name="value"
                  control={control}
                  defaultValue={[]}
                  render={({ field }) => (
                    <div>
                        <Select
                          label="Wartość"
                          options={settingValue?.value || []}
                          selected={selectedOption}
                          onChange={(value) => {
                              setSelectedOption(value);
                              const findValue = settingValue?.value.find((element) => element.value === Number(value));
                              if (findValue) {
                                  value = {
                                      id: findValue.value,
                                      name: findValue.label,
                                  };
                              }
                              field.onChange(JSON.stringify(value));
                          }}
                        />
                    </div>
                  )}
                />
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
