import Switch from '@admin/components/form/controls/Switch';
import { useState } from 'react';

const SettingValueTypeBoolean = ({setValue, formData}) => {
  const [settingValue, setSettingValue] = useState(formData.value !== 'false');


  const onChange = (e) => {
    const value = e.target.checked;

    setSettingValue(value);
    setValue('value', value ? 'true' : 'false');
  }

  return (
      <Switch label="Wartość" onChange={onChange} checked={!!settingValue} />
    )
}

export default SettingValueTypeBoolean;
