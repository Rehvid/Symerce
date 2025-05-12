const ParamTab = ({content}) => {
  const items = JSON.parse(content);
  return (
    <div className="flex flex-col gap-[2rem]">
      {Object.entries(items).map(([key, value]) => (
        <div
          key={key}
          className="flex justify-between border-b border-gray-200 pb-5"
        >
          <span className="font-medium">{key}</span>
          <div className="flex gap-2">
            {Array.isArray(value) && value.map((item, index) => (
              <span key={index}>{item}{value.length > 1 && index !== value.length - 1 ? ',' : ''} </span>
            ))}
          </div>
        </div>
      ))}
  </div>
  )
}

export default ParamTab;
