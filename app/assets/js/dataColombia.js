document.addEventListener('DOMContentLoaded', () => {
  const departamentoSelect = document.getElementById('departamento');
  const municipioSelect = document.getElementById('municipio');

  fetch('/app/assets/data/colombia.json')
    .then(res => res.json())
    .then(data => {
      // Cargar departamentos
      data.forEach(dep => {
        const option = document.createElement('option');
        option.value = dep.departamento;
        option.textContent = dep.departamento;
        departamentoSelect.appendChild(option);
      });

      // Al cambiar departamento, cargar municipios
      departamentoSelect.addEventListener('change', () => {
        municipioSelect.innerHTML = '<option value="">Seleccione un municipio</option>';

        if (!departamentoSelect.value) {
          municipioSelect.disabled = true;
          return;
        }

        const departamentoSeleccionado = data.find(d => d.departamento === departamentoSelect.value);
        if (departamentoSeleccionado) {
          departamentoSeleccionado.ciudades.forEach(mun => {
            const option = document.createElement('option');
            option.value = mun;
            option.textContent = mun;
            municipioSelect.appendChild(option);
          });
          municipioSelect.disabled = false;
        } else {
          municipioSelect.disabled = true;
        }
      });
    })
    .catch(error => {
      console.error('Error cargando datos:', error);
    });
});
