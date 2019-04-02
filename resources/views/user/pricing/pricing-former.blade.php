@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-pricing.css') }}" rel="stylesheet">
<script src="{{ asset('js/custom.js') }}"></script>

<section class="page-title">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <h1>Omnifluencer Pricing Plans</h1>
        <hr class="orn">
        <p class="pg-title">Pilih paket aktivasi Omnifluencer bergantung pada kebutuhan media sosial Anda </p>
        <div class="row" align="center">
          <div class="col-12">
            <div class="onoffswitch">
              <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" checked="checked">
              <label class="onoffswitch-label" for="myonoffswitch">
                <span class="onoffswitch-inner" data-id="1"></span>
                <span class="onoffswitch-switch"></span>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="comparison">
  <table>
    <thead>
      <tr>
        <th class="tl ">
        </th>
        <th class="qbse compare-heading ">
          FREE
        </th>
        <th class="qbse compare-heading ">
          PRO
        </th>
        <th class="qbse compare-heading ">
          PREMIUM
        </th>
      </tr>
      <tr class="">
        <th class="price-info ">
          <div class="price-now features">
            <span>Features</span>
          </div>
        </th>
        <th class="price-info ">
          <div class="price-now"><span>0,-</span></div>
          <div>
            <a href="{{url('register')}}">
              <button type="submit" class="btn btn-default btn-primary-free">
                SELECT
              </button>
            </a>
          </div>
        </th>
        <th class="price-info ">
          <div class="price-now"><span class="nprice price_pro">197,000,-</span></div>

          <div class="monthly-button">
            <a href="{{url('checkout/1')}}">
              <button class="btn select-price btn-default btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
          <div class="yearly-button">
            <a href="{{url('checkout/2')}}">
              <button class="btn select-price btn-default btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </th>
        <th class="price-info ">
          <div class="price-now"><span class="nprice price_premium">297,000,-</span></div>
          
          <div class="monthly-button">
            <a href="{{url('checkout/3')}}">
              <button class="btn btn-default select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
          <div class="yearly-button">
            <a href="{{url('checkout/4')}}">
              <button class="btn btn-default select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Influencer Report (PDF) 
          <span class="tooltipstered" title="Influencer Report (PDF)">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          Influencer Report (PDF) 
          <span class="tooltipstered" title="Influencer Report (PDF)">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="tickblue">1</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td></td>
        <td colspan="3">
          Show History 
          <span class="tooltipstered" title="Show History">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr class="compare-row">
        <td>
          Show History 
          <span class="tooltipstered" title="Show History">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="tickblue">5</span></td>
        <td><span class="tickblue">25</span></td>
        <td><span class="tickblue">Unlimited</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Save Profile 
          <span class="tooltipstered" title="Save Profile">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          Save Profile 
          <span class="tooltipstered" title="Save Profile">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">25</span></td>
        <td><span class="tickblue">Unlimited</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Compare 
          <span class="tooltipstered" title="Compare">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr class="compare-row">
        <td>
          Compare 
          <span class="tooltipstered" title="Compare">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">Yes - 2</span></td>
        <td><span class="tickblue">Yes - 4</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Compare From History 
          <span class="tooltipstered" title="Compare From History">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          Compare From History 
          <span class="tooltipstered" title="Compare From History">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">Yes - 2</span></td>
        <td><span class="tickblue">Yes - 4</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Grouping 
          <span class="tooltipstered" title="Grouping">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr class="compare-row">
        <td>
          Grouping 
          <span class="tooltipstered" title="Grouping">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Multi Group 
          <span class="tooltipstered" title="Multi Group">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          Multi Group 
          <span class="tooltipstered" title="Multi Group">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Multi Delete 
          <span class="tooltipstered" title="Multi Delete">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr class="compare-row">
        <td>
          Multi Delete 
          <span class="tooltipstered" title="Multi Delete">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Multi Influencers Report (PDF) 
          <span class="tooltipstered" title="Multi Influencer Report (PDF)">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr class="compare-row">
        <td>
          Multi Influencers Report (PDF) 
          <span class="tooltipstered" title="Multi Influencer Report (PDF)">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Multi Influencers List (Excel) 
          <span class="tooltipstered" title="Multi Influencer List (Excel)">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
      </tr>
      <tr>
        <td>
          Multi Influencers List (Excel) 
          <span class="tooltipstered" title="Multi Influencer List (Excel)">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">
          Agency Logo for Report (PDF)
          <span class="tooltipstered" data-tooltip-content="#tooltip_content">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>

        <div class="tooltip_templates" style="display: none;">
          <span id="tooltip_content">
            <img src="{{asset('design/agency-logo.PNG')}}" style="width:175px" /><br> 
            <strong>
              Agency Logo for Report (PDF)
            </strong>
          </span>
        </div>
      </tr>
      <tr>
        <td>
          Agency Logo for Report (PDF)
          <span class="tooltipstered" data-tooltip-content="#tooltip_content">
            <i class="fas fa-question-circle fonticon"></i>
          </span>
        </td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="cross">&#10060;</span></td>
        <td><span class="tickblue">&check;</span></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="3">Buy Now</td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div>
            <a href="{{url('register')}}">
              <button class="btn btn-default select-price btn-primary-free" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </td>
        <td>
          <div class="monthly-button">
            <a href="{{url('checkout/1')}}">
              <button class="btn select-price btn-success btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
          <div class="yearly-button">
            <a href="{{url('checkout/2')}}">
              <button class="btn select-price btn-success btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </td>
        <td>
          <div class="monthly-button">
            <a href="{{url('checkout/3')}}">
              <button class="btn btn-success select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
          <div class="yearly-button">
            <a href="{{url('checkout/4')}}">
              <button class="btn btn-success select-price btn-primary-prc" data-package="1">
                SELECT
              </button>
            </a>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
</div>
@endsection
