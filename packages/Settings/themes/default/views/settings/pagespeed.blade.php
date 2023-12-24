<script>
    function run() {
      const url = setUpQuery();
      fetch(url)
        .then(response => response.json())
        .then(json => {
          // See https://developers.google.com/speed/docs/insights/v5/reference/pagespeedapi/runpagespeed#response
          // to learn more about each of the properties in the response object.
          showInitialContent(json.id);
          const cruxMetrics = {
            "First Contentful Paint": json.loadingExperience.metrics.FIRST_CONTENTFUL_PAINT_MS.category,
            "First Input Delay": json.loadingExperience.metrics.FIRST_INPUT_DELAY_MS.category
          };
          showCruxContent(cruxMetrics);
          const lighthouse = json.lighthouseResult;
          const lighthouseMetrics = {
            'First Contentful Paint': lighthouse.audits['first-contentful-paint'].displayValue,
            'Speed Index': lighthouse.audits['speed-index'].displayValue,
            'Time To Interactive': lighthouse.audits['interactive'].displayValue,
            'First Meaningful Paint': lighthouse.audits['first-meaningful-paint'].displayValue,
            'First CPU Idle': lighthouse.audits['first-cpu-idle'].displayValue,
            'Estimated Input Latency': lighthouse.audits['estimated-input-latency'].displayValue
          };
          showLighthouseContent(lighthouseMetrics);
        });
    }
    
    function setUpQuery() {
      const api = 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed';
      // const apiKey = 'AIzaSyAjNcPRSIcr9Sp4VC8DATT_4d9UkksO2OQ';
      const parameters = {
        url: encodeURIComponent('https://lemyk.com/')
        // key: apiKey
      };
      let query = `${api}?`;
      for (key in parameters) {
        query += `${key}=${parameters[key]}`;
      }
      return query;
    }
    
    function showInitialContent(id) {
      const contentDiv = document.querySelector('.ibox-content.shadowed');
      contentDiv.innerHTML = '';
      const title = document.createElement('h1');
      title.textContent = 'PageSpeed Insights API Demo';
      const page = document.createElement('p');
      page.textContent = `Page tested: ${id}`;
      contentDiv.appendChild(title);
      contentDiv.appendChild(page);
    }

    function showCruxContent(cruxMetrics) {
      const contentDiv = document.querySelector('.ibox-content.shadowed');
      const cruxHeader = document.createElement('h2');
      cruxHeader.textContent = "Chrome User Experience Report Results";
      contentDiv.appendChild(cruxHeader);

      for (const key in cruxMetrics) {
        const p = document.createElement('p');
        p.textContent = `${key}: ${cruxMetrics[key]}`;
        contentDiv.appendChild(p);
      }
    }

    function showLighthouseContent(lighthouseMetrics) {
      const contentDiv = document.querySelector('.ibox-content.shadowed');
      const lighthouseHeader = document.createElement('h2');
      lighthouseHeader.textContent = "Lighthouse Results";
      contentDiv.appendChild(lighthouseHeader);

      for (const key in lighthouseMetrics) {
        const p = document.createElement('p');
        p.textContent = `${key}: ${lighthouseMetrics[key]}`;
        contentDiv.appendChild(p);
      }
    }

    run();
</script>