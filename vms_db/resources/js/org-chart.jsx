import React, { useState } from 'react';
import { createRoot } from 'react-dom/client';
import { Users, Calendar, Target, Utensils, Truck, Package, UserCheck, Shield, MapPin, ChevronDown, ChevronRight, Printer } from 'lucide-react';

const OrgChart = ({ orgData }) => {
  // If orgData is missing or incomplete, render a friendly placeholder
  if (!orgData || !orgData.teams) {
    return (
      <div className="min-h-screen bg-white p-8">
        <div className="max-w-3xl mx-auto text-center text-gray-700">
          <h2 className="text-2xl font-semibold mb-2">No organization chart data available</h2>
          <p className="text-sm">Please ensure the organization chart is configured in the admin panel.</p>
        </div>
      </div>
    );
  }
  // compact mode toggle for denser display
  const [compact, setCompact] = useState(false);

  const TeamBox = ({ title, type, leader, members, className = '' }) => {
    const [open, setOpen] = useState(true);
    return (
      <div className={`border-2 border-gray-200 bg-white p-3 rounded-lg shadow-sm ${className}`}>
        <div className="flex items-center justify-between mb-2">
          <div>
            <div className="font-bold text-gray-900 text-sm">{title}</div>
            {type && <div className="text-xs text-orange-600">({type})</div>}
          </div>
          <button onClick={() => setOpen(!open)} className="text-gray-500 hover:text-gray-700 p-1">
            {open ? <ChevronDown className="w-4 h-4" /> : <ChevronRight className="w-4 h-4" />}
          </button>
        </div>
        {leader && (
          <div className="text-sm text-gray-700 mb-2">
            <span className="text-orange-600">^</span> {leader}
          </div>
        )}
        {open && members && members.length > 0 && (
          <div className={`text-xs text-gray-600 ${compact ? 'grid grid-cols-2 gap-1' : 'space-y-1'}`}>
            {members.map((member, idx) => (
              <div key={idx} className="truncate">{member}</div>
            ))}
          </div>
        )}
      </div>
    );
  };

  const RoleBox = ({ title, name, icon: Icon }) => (
    <div className="border-2 border-gray-800 bg-white p-3 rounded shadow-sm text-center">
      <div className="flex items-center justify-center gap-2 mb-1">
        {Icon && <Icon className="w-4 h-4 text-orange-600" />}
        <div className="font-bold text-gray-900 text-sm">{title}</div>
      </div>
      <div className="text-sm text-gray-700">{name}</div>
    </div>
  );

  const SimpleBox = ({ title, items, className = '' }) => (
    <div className={`border-2 border-gray-800 bg-white p-3 rounded shadow-sm ${className}`}>
      <div className="font-bold text-gray-900 text-sm mb-2">{title}</div>
      <div className="text-xs text-gray-700">
        {items.map((item, idx) => (
          <div key={idx}>
            {idx > 0 && <span className="text-orange-600">^</span>}
            {item}
          </div>
        ))}
      </div>
    </div>
  );

  const ConnectionLine = ({ vertical = false, className = '' }) => (
    <div className={`${vertical ? 'h-8 w-0.5' : 'w-8 h-0.5'} bg-gray-800 ${className}`} />
  );

  const SVGConnectionLine = ({ from, to, className = '' }) => (
    <svg className={`absolute pointer-events-none ${className}`} style={{ zIndex: 1 }}>
      <line
        x1={from.x}
        y1={from.y}
        x2={to.x}
        y2={to.y}
        stroke="#374151"
        strokeWidth="2"
        strokeDasharray="none"
      />
    </svg>
  );

  return (
    <div className="min-h-screen bg-gradient-to-b from-gray-100 to-gray-50 py-10">
      <div className="max-w-7xl mx-auto px-4">
        {/* Header */}
        <div className="mb-6 bg-white p-6 rounded-xl shadow-md border border-gray-100">
          <div className="flex items-start justify-between gap-4 flex-wrap">
            <div className="flex items-center gap-3">
              <Utensils className="w-8 h-8 text-orange-600" />
              <div>
                <h1 className="text-2xl md:text-3xl font-bold text-gray-900">Mobile Kitchen Operations</h1>
                <p className="text-sm text-gray-600 mt-1">Organization chart and assignments</p>
              </div>
            </div>

            <div className="flex items-center gap-3">
              <button onClick={() => window.print()} className="inline-flex items-center gap-2 px-3 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700">
                <Printer className="w-4 h-4" /> Print
              </button>
              <button onClick={() => setCompact(!compact)} className="inline-flex items-center gap-2 px-3 py-2 border rounded-md bg-white">
                {compact ? 'Expanded' : 'Compact'}
              </button>
            </div>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div className="flex items-center gap-2">
              <Calendar className="w-5 h-5 text-orange-600" />
              <span className="font-semibold text-gray-900">DATE:</span>
              <span className="text-gray-700">{orgData.date}</span>
            </div>
            <div className="flex items-center gap-2">
              <Users className="w-5 h-5 text-orange-600" />
              <span className="font-semibold text-gray-900">VOLUNTEERS:</span>
              <span className="text-gray-700">{orgData.volunteers_count ?? orgData.volunteers}</span>
            </div>
            <div className="flex items-center gap-2">
              <Target className="w-5 h-5 text-orange-600" />
              <span className="font-semibold text-gray-900">OBJECTIVE:</span>
              <span className="text-gray-700">{orgData.objective}</span>
            </div>
            <div className="flex items-center gap-2">
              <Utensils className="w-5 h-5 text-orange-600" />
              <span className="font-semibold text-gray-900">MENU:</span>
              <span className="text-gray-700">{orgData.menu}</span>
            </div>
          </div>
        </div>

        {/* Organization Chart */}
        <div className="space-y-6">
          {/* Top Level */}
          <div className="flex flex-col items-center">
            <RoleBox
              title="RESPONSIBLE OFFICIAL"
              name={orgData.responsibleOfficial}
              icon={Shield}
            />
            <ConnectionLine vertical />
            <RoleBox
              title="INCIDENT COMMANDER"
              name={orgData.incidentCommander}
              icon={Users}
            />
          </div>

          {/* Planning Section */}
          <div className="flex justify-center gap-8">
            <div className="flex flex-col items-center">
              <div className="w-full md:w-96 grid grid-cols-1 gap-3">
                <RoleBox title="PLANNING" name={orgData.planning} />
                <RoleBox title="PURCHASING" name={orgData.purchasing} />
                <RoleBox title="MWC COORDINATOR" name={orgData.mwc_coordinator} />
                <RoleBox title="SAFETY & EMERGENCY" name={orgData.safety_emergency} />
              </div>
            </div>
          </div>

          {/* Three Main Sections */}
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            {/* Left Column - Mobile Kitchen */}
            <div className="space-y-4">
              <div className="bg-orange-50 p-3 rounded font-bold text-center text-gray-900 border border-orange-100">
                MOBILE KITCHEN
                <div className="text-sm font-normal italic mt-1">{orgData.mobile_kitchen}</div>
              </div>

              <SimpleBox
                title="KITCHEN TRUCK"
                items={orgData.kitchen_truck || []}
              />

              <SimpleBox
                title="FOOD PREP"
                items={orgData.food_prep || []}
              />

              <SimpleBox
                title="VOLUNTEER CARE"
                items={orgData.volunteer_care || []}
              />

              <SimpleBox
                title="WASH / CLEAN UP"
                items={orgData.wash_cleanup || []}
              />

              <SimpleBox
                title="INVENTORY"
                items={orgData.inventory || []}
              />
            </div>

            {/* Middle Column - AM Distribution */}
            <div className="space-y-4">
              <div className="border-2 border-orange-600 bg-orange-50 p-3 rounded font-bold text-center text-gray-900">
                AM DISTRIBUTION<br/>
                <span className="text-sm font-normal italic">{orgData.am_distribution}</span>
              </div>

              {/* Render AM teams (only expected AM keys) */}
              {['alpha', 'bravo', 'charlie1', 'charlie2'].map((key) => {
                if (!orgData.teams || !orgData.teams[key]) return null;
                const t = orgData.teams[key] || {};
                return (
                  <TeamBox
                    key={key}
                    title={String(key).toUpperCase()}
                    type={t.type}
                    leader={t.leader}
                    members={t.members}
                  />
                );
              })}
            </div>

            {/* Right Column - PM Distribution */}
            <div className="space-y-4">
              <div className="border-2 border-orange-600 bg-orange-50 p-3 rounded font-bold text-center text-gray-900">
                PM DISTRIBUTION<br/>
                <span className="text-sm font-normal italic">{orgData.pm_distribution}</span>
              </div>

              {['delta1', 'delta2', 'echo', 'foxtrot'].map((key) => {
                if (!orgData.teams || !orgData.teams[key]) return null;
                const t = orgData.teams[key] || {};
                return (
                  <TeamBox
                    key={key + '-pm'}
                    title={String(key).toUpperCase()}
                    type={t.type}
                    leader={t.leader}
                    members={t.members}
                  />
                );
              })}
            </div>
          </div>

          {/* Bottom Section - Info Boxes */}
          <div className="grid grid-cols-3 gap-6 mt-8">
            <div className="border-2 border-orange-600 bg-orange-50 p-4 rounded">
              <h3 className="font-bold text-gray-900 mb-3">SYMBOLS</h3>
              <div className="text-sm text-gray-700 space-y-1">
                <div>* new volunteer</div>
                <div>~ driver</div>
                <div>^/^ team leader</div>
              </div>
            </div>

            <div className="border-2 border-orange-600 bg-orange-50 p-4 rounded">
              <h3 className="font-bold text-gray-900 mb-3">MEAL BREAKDOWN</h3>
              <div className="text-sm text-gray-700 space-y-1">
                <div>Breakfast - {orgData.meal_breakdown.breakfast}</div>
                <div>Lunch - {orgData.meal_breakdown.lunch}</div>
                <div>Snacks - {orgData.meal_breakdown.snacks}</div>
              </div>
            </div>

            <div className="border-2 border-orange-600 bg-orange-50 p-4 rounded">
              <h3 className="font-bold text-gray-900 mb-3 flex items-center gap-2">
                <Truck className="w-5 h-5" />
                VEHICLE ASSIGNMENT
              </h3>
              <div className="text-xs text-gray-700 space-y-1">
                {(orgData.vehicles || []).map((v, idx) => (
                  <div key={idx}>{v.team} - {v.vehicle}</div>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Print Button */}
        <div className="mt-8 text-center">
          <button
            onClick={() => window.print()}
            className="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transition-colors"
          >
            Print Organization Chart
          </button>
        </div>
      </div>
    </div>
  );
};

// Mount if element exists and window.__ORG_CHART_DATA__ is provided
function mountOrgChart() {
  const container = document.getElementById('org-chart');
  if (!container) return;
  const data = window.__ORG_CHART_DATA__ || {};
  const root = createRoot(container);
  root.render(<OrgChart orgData={data} />);
}

// If the document is already loaded, mount immediately; otherwise wait for DOMContentLoaded
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', mountOrgChart);
} else {
  mountOrgChart();
}

export default OrgChart;
